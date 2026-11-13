<?php
/**
 * Post-purchase invoice details form — private individuals only.
 * Link from license email: /invoice-details/?d=<token>&key=<license>
 * Token: AES-256-GCM, key=SHA-256(BILLING_FORM_SECRET), base64url(iv||tag||ciphertext).
 * Matches license-server/billingFormToken.js
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Max age of billing form token (90 days). */
if ( ! defined( 'NOAWAY_BILLING_FORM_TOKEN_MAX_AGE' ) ) {
	define( 'NOAWAY_BILLING_FORM_TOKEN_MAX_AGE', 90 * DAY_IN_SECONDS );
}

/** Max invoice-form submissions per IP per window. */
if ( ! defined( 'NOAWAY_INVOICE_RATE_LIMIT' ) ) {
	define( 'NOAWAY_INVOICE_RATE_LIMIT', 8 );
}
if ( ! defined( 'NOAWAY_INVOICE_RATE_WINDOW' ) ) {
	define( 'NOAWAY_INVOICE_RATE_WINDOW', HOUR_IN_SECONDS );
}

/**
 * Shared secret (same as license-server BILLING_FORM_SECRET).
 *
 * @return string
 */
function noaway_billing_form_secret() {
	if ( defined( 'NOAWAY_BILLING_FORM_SECRET' ) && is_string( NOAWAY_BILLING_FORM_SECRET ) && NOAWAY_BILLING_FORM_SECRET !== '' ) {
		return NOAWAY_BILLING_FORM_SECRET;
	}
	return '';
}

/**
 * Public URL for the invoice-details page.
 *
 * @return string
 */
function noaway_invoice_details_page_url() {
	return noaway_page_url_by_template( 'page-invoice-details.php', '/invoice-details/' );
}

/**
 * @param string $data base64url string.
 * @return string|false
 */
function noaway_billing_base64url_decode( $data ) {
	$data = is_string( $data ) ? trim( $data ) : '';
	if ( $data === '' ) {
		return false;
	}
	$remainder = strlen( $data ) % 4;
	if ( $remainder > 0 ) {
		$data .= str_repeat( '=', 4 - $remainder );
	}
	$raw = base64_decode( strtr( $data, '-_', '+/' ), true );
	return $raw === false ? false : $raw;
}

/**
 * Decrypt billing form token (AES-256-GCM).
 *
 * @param string $token base64url.
 * @return array{license_key:string,email:string,name:?string,iat:int}|WP_Error
 */
function noaway_billing_decrypt_token( $token ) {
	$secret = noaway_billing_form_secret();
	if ( $secret === '' ) {
		return new WP_Error( 'no_secret', 'Billing form secret is not configured.' );
	}
	$buf = noaway_billing_base64url_decode( $token );
	if ( $buf === false || strlen( $buf ) < 12 + 16 + 1 ) {
		return new WP_Error( 'invalid_token', 'Invalid billing form token.' );
	}
	$iv         = substr( $buf, 0, 12 );
	$tag        = substr( $buf, 12, 16 );
	$ciphertext = substr( $buf, 28 );
	$key        = hash( 'sha256', $secret, true );
	$plain      = openssl_decrypt( $ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag );
	if ( $plain === false ) {
		return new WP_Error( 'decrypt_failed', 'Could not decrypt billing form token.' );
	}
	$data = json_decode( $plain, true );
	if ( ! is_array( $data ) || empty( $data['license_key'] ) || empty( $data['email'] ) ) {
		return new WP_Error( 'bad_payload', 'Invalid billing form payload.' );
	}
	$iat = isset( $data['iat'] ) ? (int) $data['iat'] : 0;
	// Node uses Date.now() (ms); accept seconds too.
	if ( $iat > 1000000000000 ) {
		$iat_sec = (int) floor( $iat / 1000 );
	} else {
		$iat_sec = $iat;
	}
	if ( $iat_sec <= 0 || ( time() - $iat_sec ) > (int) NOAWAY_BILLING_FORM_TOKEN_MAX_AGE ) {
		return new WP_Error( 'expired', 'This invoice link has expired. Contact support@noaway.app.' );
	}
	return array(
		'license_key' => (string) $data['license_key'],
		'email'       => (string) $data['email'],
		'name'        => isset( $data['name'] ) && $data['name'] !== null && $data['name'] !== '' ? (string) $data['name'] : null,
		'iat'         => $iat_sec,
	);
}

/**
 * Resolve prefill context from request query args.
 *
 * @return array{ok:bool,license_key:string,email:string,name:string,token:string,error:string}
 */
function noaway_invoice_details_context_from_request() {
	$out = array(
		'ok'          => false,
		'license_key' => '',
		'email'       => '',
		'name'        => '',
		'token'       => '',
		'error'       => '',
	);

	$token = isset( $_GET['d'] ) ? sanitize_text_field( wp_unslash( $_GET['d'] ) ) : '';
	$key   = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';

	// Design preview: shows the form UI without a signed purchase link.
	// Submissions are still rejected unless a valid token (or plaintext fallback) is present.
	if ( isset( $_GET['preview'] ) && (string) wp_unslash( $_GET['preview'] ) === '1' && $token === '' ) {
		$out['ok']          = true;
		$out['license_key'] = 'PREVIEW-LICENSE';
		$out['email']       = 'preview@noaway.app';
		$out['name']        = 'Alex Preview';
		return $out;
	}

	if ( $token !== '' ) {
		$payload = noaway_billing_decrypt_token( $token );
		if ( is_wp_error( $payload ) ) {
			$out['error'] = $payload->get_error_message();
			return $out;
		}
		if ( $key !== '' && ! hash_equals( $payload['license_key'], $key ) ) {
			$out['error'] = 'This invoice link is invalid. Please use the link from your purchase email.';
			return $out;
		}
		$out['ok']          = true;
		$out['license_key'] = $payload['license_key'];
		$out['email']       = $payload['email'];
		$out['name']        = $payload['name'] ? $payload['name'] : '';
		$out['token']       = $token;
		return $out;
	}

	// Fallback when BILLING_FORM_SECRET was missing at email send time (plaintext query).
	$email = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( $_GET['email'] ) ) : '';
	$name  = isset( $_GET['name'] ) ? sanitize_text_field( wp_unslash( $_GET['name'] ) ) : '';
	if ( $key !== '' && is_email( $email ) && noaway_billing_form_secret() === '' ) {
		$out['ok']          = true;
		$out['license_key'] = $key;
		$out['email']       = $email;
		$out['name']        = $name;
		return $out;
	}

	$out['error'] = 'Open this page from the link in your NoAway purchase email.';
	return $out;
}

/**
 * Country options for the form (ISO 3166-1 alpha-2 => label).
 *
 * @return array<string,string>
 */
function noaway_invoice_country_options() {
	return array(
		'IT' => 'Italy',
		'US' => 'United States',
		'GB' => 'United Kingdom',
		'DE' => 'Germany',
		'FR' => 'France',
		'ES' => 'Spain',
		'PT' => 'Portugal',
		'NL' => 'Netherlands',
		'BE' => 'Belgium',
		'CH' => 'Switzerland',
		'AT' => 'Austria',
		'IE' => 'Ireland',
		'PL' => 'Poland',
		'SE' => 'Sweden',
		'NO' => 'Norway',
		'DK' => 'Denmark',
		'FI' => 'Finland',
		'CA' => 'Canada',
		'AU' => 'Australia',
		'BR' => 'Brazil',
		'MX' => 'Mexico',
		'AR' => 'Argentina',
		'IN' => 'India',
		'JP' => 'Japan',
		'KR' => 'South Korea',
		'SG' => 'Singapore',
		'AE' => 'United Arab Emirates',
		'OTHER' => 'Other (specify in address notes)',
	);
}

/**
 * @param string $ip_hash Hashed IP.
 * @return true|WP_Error
 */
function noaway_invoice_check_rate_limit( $ip_hash ) {
	$key   = 'noaway_inv_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	if ( $count >= (int) NOAWAY_INVOICE_RATE_LIMIT ) {
		return new WP_Error( 'rate_limited', 'Too many requests.' );
	}
	return true;
}

/**
 * @param string $ip_hash Hashed IP.
 */
function noaway_invoice_bump_rate_limit( $ip_hash ) {
	$key   = 'noaway_inv_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	set_transient( $key, $count + 1, (int) NOAWAY_INVOICE_RATE_WINDOW );
}

/**
 * Redirect back to invoice-details with status.
 *
 * @param string               $status sent|error|invalid.
 * @param array<string,string> $keep   Query args to preserve (d, key).
 */
function noaway_invoice_redirect( $status, array $keep = array() ) {
	$url = noaway_invoice_details_page_url();
	$args = array( 'invoice' => $status );
	if ( ! empty( $keep['d'] ) ) {
		$args['d'] = $keep['d'];
	}
	if ( ! empty( $keep['key'] ) ) {
		$args['key'] = $keep['key'];
	}
	$url = add_query_arg( $args, $url );
	wp_safe_redirect( $url );
	exit;
}

/**
 * Email support with submitted billing data.
 *
 * @param array<string,string> $data Sanitized fields.
 * @return bool
 */
function noaway_invoice_send_support_notice( array $data ) {
	$support = function_exists( 'noaway_contact_support_email' ) ? noaway_contact_support_email() : 'support@noaway.app';
	$brand   = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.brand', 'NoAway' ) : 'NoAway';

	$subject = "[{$brand} Invoice] Billing details — {$data['full_name']} — {$data['license_key']}";

	$lines = array(
		'New invoice billing details (private individual)',
		'',
		'License key: ' . $data['license_key'],
		'Purchase email: ' . $data['email'],
		'',
		'Full name: ' . $data['full_name'],
		'Street address: ' . $data['address'],
		'City / Municipality: ' . $data['city'],
		'Postal / ZIP (CAP): ' . $data['postal'],
		'Province / State: ' . $data['province'],
		'Country: ' . $data['country_label'] . ' (' . $data['country'] . ')',
		'Tax code (Codice Fiscale): ' . ( $data['tax_code'] !== '' ? $data['tax_code'] : '(not provided)' ),
		'Address notes: ' . ( $data['address_notes'] !== '' ? $data['address_notes'] : '(none)' ),
		'',
		'Submitted at: ' . gmdate( 'Y-m-d H:i:s' ) . ' UTC',
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: ' . $brand . ' Website <' . $support . '>',
		'Reply-To: ' . $data['full_name'] . ' <' . $data['email'] . '>',
	);

	return (bool) wp_mail( $support, $subject, implode( "\n", $lines ), $headers );
}

/**
 * Confirmation email to the buyer.
 *
 * @param string $to   Buyer email.
 * @param string $name Buyer name.
 * @return bool
 */
function noaway_invoice_send_buyer_confirm( $to, $name ) {
	$support = function_exists( 'noaway_contact_support_email' ) ? noaway_contact_support_email() : 'support@noaway.app';
	$brand   = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.brand', 'NoAway' ) : 'NoAway';
	$site    = esc_url( home_url( '/' ) );
	$logo    = esc_url( function_exists( 'noaway_contact_email_logo_url' ) ? noaway_contact_email_logo_url() : '' );
	$primary = '#5851ec';
	$first   = trim( (string) $name );
	if ( $first !== '' ) {
		$parts = preg_split( '/\s+/', $first );
		$first = is_array( $parts ) && isset( $parts[0] ) ? $parts[0] : $first;
	}
	$greeting = $first !== '' ? 'Hi ' . esc_html( $first ) . ',' : 'Hi,';

	ob_start();
	?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>We received your invoice details</title></head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#0f172a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f1f5f9;padding:32px 16px;">
<tr><td align="center">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:560px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
<tr><td style="padding:28px 32px 16px;text-align:center;border-bottom:1px solid #e2e8f0;">
<?php if ( $logo ) : ?>
<a href="<?php echo $site; ?>" style="text-decoration:none;"><img src="<?php echo $logo; ?>" width="64" height="64" alt="<?php echo esc_attr( $brand ); ?>" style="display:inline-block;border:0;border-radius:12px;"></a>
<?php endif; ?>
<div style="margin-top:12px;font-size:20px;font-weight:800;color:#0f172a;"><?php echo esc_html( $brand ); ?></div>
</td></tr>
<tr><td style="padding:28px 32px;font-size:16px;line-height:1.6;color:#334155;">
<p style="margin:0 0 16px;"><?php echo $greeting; ?></p>
<p style="margin:0 0 16px;">Thank you — we have received your billing details for the Italian electronic invoice.</p>
<p style="margin:0 0 16px;">We will issue the invoice shortly. You do not need to send anything else unless we contact you.</p>
<p style="margin:0;">— The <?php echo esc_html( $brand ); ?> team</p>
</td></tr>
<tr><td style="padding:20px 32px 28px;font-size:12px;color:#94a3b8;border-top:1px solid #e2e8f0;">
<a href="mailto:<?php echo esc_attr( $support ); ?>" style="color:<?php echo esc_attr( $primary ); ?>;text-decoration:none;"><?php echo esc_html( $support ); ?></a>
· <a href="<?php echo $site; ?>" style="color:<?php echo esc_attr( $primary ); ?>;text-decoration:none;">noaway.app</a>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>
	<?php
	$html = (string) ob_get_clean();

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $brand . ' <' . $support . '>',
		'Reply-To: ' . $support,
	);
	return (bool) wp_mail( $to, "We received your invoice details — {$brand}", $html, $headers );
}

/**
 * Handle invoice form POST.
 */
function noaway_invoice_handle_submit() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( empty( $_POST['noaway_invoice_form'] ) ) {
		return;
	}

	$token = isset( $_POST['invoice_token'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_token'] ) ) : '';
	$key   = isset( $_POST['invoice_license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_license_key'] ) ) : '';
	$keep  = array();
	if ( $token !== '' ) {
		$keep['d'] = $token;
	}
	if ( $key !== '' ) {
		$keep['key'] = $key;
	}

	$ip_hash = function_exists( 'noaway_contact_ip_hash' )
		? noaway_contact_ip_hash( noaway_contact_client_ip() )
		: hash( 'sha256', ( isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '0' ) . '|' . wp_salt( 'nonce' ) );

	$honeypot = isset( $_POST['invoice_website'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_website'] ) ) : '';
	if ( $honeypot !== '' ) {
		noaway_invoice_bump_rate_limit( $ip_hash );
		noaway_invoice_redirect( 'sent', $keep );
	}

	if ( ! isset( $_POST['noaway_invoice_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['noaway_invoice_nonce'] ) ), 'noaway_invoice' ) ) {
		noaway_invoice_redirect( 'error', $keep );
	}

	$rate = noaway_invoice_check_rate_limit( $ip_hash );
	if ( is_wp_error( $rate ) ) {
		noaway_invoice_redirect( 'error', $keep );
	}

	$email_from_token = '';
	$license_from_token = '';
	if ( $token !== '' ) {
		$payload = noaway_billing_decrypt_token( $token );
		if ( is_wp_error( $payload ) ) {
			noaway_invoice_redirect( 'invalid', $keep );
		}
		$email_from_token   = $payload['email'];
		$license_from_token = $payload['license_key'];
		if ( $key !== '' && ! hash_equals( $license_from_token, $key ) ) {
			noaway_invoice_redirect( 'invalid', $keep );
		}
		$key = $license_from_token;
	} else {
		// Plaintext fallback path only when secret is unset.
		if ( noaway_billing_form_secret() !== '' || $key === '' ) {
			noaway_invoice_redirect( 'invalid', $keep );
		}
		$email_from_token = isset( $_POST['invoice_email'] ) ? sanitize_email( wp_unslash( $_POST['invoice_email'] ) ) : '';
	}

	$email = $email_from_token !== '' ? $email_from_token : ( isset( $_POST['invoice_email'] ) ? sanitize_email( wp_unslash( $_POST['invoice_email'] ) ) : '' );
	if ( ! is_email( $email ) || $key === '' ) {
		noaway_invoice_redirect( 'error', $keep );
	}

	$full_name     = isset( $_POST['invoice_full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_full_name'] ) ) : '';
	$address       = isset( $_POST['invoice_address'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_address'] ) ) : '';
	$city          = isset( $_POST['invoice_city'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_city'] ) ) : '';
	$postal         = isset( $_POST['invoice_postal'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_postal'] ) ) : '';
	$province      = isset( $_POST['invoice_province'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_province'] ) ) : '';
	$country       = isset( $_POST['invoice_country'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['invoice_country'] ) ) ) : '';
	$tax_code      = isset( $_POST['invoice_tax_code'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['invoice_tax_code'] ) ) ) : '';
	$address_notes = isset( $_POST['invoice_address_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['invoice_address_notes'] ) ) : '';

	$countries = noaway_invoice_country_options();
	if ( $full_name === '' || $address === '' || $city === '' || $postal === '' || $province === '' || ! isset( $countries[ $country ] ) ) {
		noaway_invoice_redirect( 'error', $keep );
	}

	// Italian residents: codice fiscale is required for e-invoice to private individuals.
	$tax_code = preg_replace( '/\s+/', '', $tax_code );
	if ( $country === 'IT' ) {
		if ( ! is_string( $tax_code ) || ! preg_match( '/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[A-EHLMPRST][0-9LMNPQRSTUV]{2}[A-Z][0-9LMNPQRSTUV]{3}[A-Z]$/', $tax_code ) ) {
			noaway_invoice_redirect( 'error', $keep );
		}
		$province = strtoupper( $province );
		if ( ! preg_match( '/^[A-Z]{2}$/', $province ) ) {
			noaway_invoice_redirect( 'error', $keep );
		}
	} else {
		$tax_code = is_string( $tax_code ) ? $tax_code : '';
	}

	$data = array(
		'license_key'   => $key,
		'email'         => $email,
		'full_name'     => $full_name,
		'address'       => $address,
		'city'          => $city,
		'postal'         => $postal,
		'province'      => $province,
		'country'       => $country,
		'country_label' => $countries[ $country ],
		'tax_code'      => $tax_code,
		'address_notes' => $address_notes,
	);

	if ( ! noaway_invoice_send_support_notice( $data ) ) {
		noaway_invoice_redirect( 'error', $keep );
	}

	noaway_invoice_send_buyer_confirm( $email, $full_name );
	noaway_invoice_bump_rate_limit( $ip_hash );
	noaway_invoice_redirect( 'sent', $keep );
}
add_action( 'template_redirect', 'noaway_invoice_handle_submit', 5 );

/**
 * Ensure published page at /invoice-details/.
 */
function noaway_ensure_invoice_details_page() {
	if ( ! function_exists( 'wp_insert_post' ) ) {
		return;
	}
	$page = get_page_by_path( 'invoice-details', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		$needs   = array( 'ID' => (int) $page->ID );
		$changed = false;
		if ( $page->post_status !== 'publish' ) {
			$needs['post_status'] = 'publish';
			$changed              = true;
		}
		if ( $page->post_name !== 'invoice-details' ) {
			$needs['post_name'] = 'invoice-details';
			$changed            = true;
		}
		if ( $changed ) {
			wp_update_post( $needs );
		}
		$tpl = get_post_meta( (int) $page->ID, '_wp_page_template', true );
		if ( $tpl !== 'page-invoice-details.php' ) {
			update_post_meta( (int) $page->ID, '_wp_page_template', 'page-invoice-details.php' );
		}
		return;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Invoice details',
			'post_name'    => 'invoice-details',
			'post_content' => '',
			'post_parent'  => 0,
			'meta_input'   => array(
				'_wp_page_template' => 'page-invoice-details.php',
			),
		),
		true
	);
	if ( ! is_wp_error( $id ) && $id ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'after_switch_theme', 'noaway_ensure_invoice_details_page' );
add_action( 'admin_init', 'noaway_ensure_invoice_details_page', 33 );

/**
 * noindex — post-purchase form, not for search engines.
 *
 * @param array<string,bool|string> $robots Robots directives.
 * @return array<string,bool|string>
 */
function noaway_invoice_details_robots( $robots ) {
	if ( is_page_template( 'page-invoice-details.php' ) || is_page( 'invoice-details' ) ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
		$robots['noarchive'] = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'noaway_invoice_details_robots' );
