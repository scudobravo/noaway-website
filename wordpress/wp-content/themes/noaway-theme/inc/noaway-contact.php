<?php
/**
 * Contact form handler — notify support + HTML auto-reply to the sender.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Max contact submissions per IP per window. */
if ( ! defined( 'NOAWAY_CONTACT_RATE_LIMIT' ) ) {
	define( 'NOAWAY_CONTACT_RATE_LIMIT', 5 );
}
/** Rate-limit window in seconds. */
if ( ! defined( 'NOAWAY_CONTACT_RATE_WINDOW' ) ) {
	define( 'NOAWAY_CONTACT_RATE_WINDOW', HOUR_IN_SECONDS );
}

/**
 * Support inbox address.
 *
 * @return string
 */
function noaway_contact_support_email() {
	$email = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.support_email', '' ) : '';
	if ( ! is_email( $email ) ) {
		$email = 'support@noaway.app';
	}
	return $email;
}

/**
 * Allowed contact topics (must match page-contatti.php options).
 *
 * @return string[]
 */
function noaway_contact_allowed_topics() {
	return array(
		'General Question',
		'Technical Support',
		'License Issue',
		'Billing Question',
		'Other',
	);
}

/**
 * Absolute logo URL for HTML emails (PNG — widely supported by clients).
 *
 * @return string
 */
function noaway_contact_email_logo_url() {
	$url = '';
	if ( function_exists( 'noaway_theme_image_url' ) ) {
		$url = noaway_theme_image_url( 'favicon-192.png' );
	} else {
		$url = get_template_directory_uri() . '/assets/images/favicon-192.png';
	}
	return (string) apply_filters( 'noaway_contact_email_logo_url', $url );
}

/**
 * Client IP (best-effort; hashed before storage).
 *
 * @return string
 */
function noaway_contact_client_ip() {
	$ip = '';
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && is_string( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
		$ip = wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) && is_string( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = wp_unslash( $_SERVER['REMOTE_ADDR'] );
	}
	$ip = is_string( $ip ) ? trim( $ip ) : '';
	if ( $ip === '' || ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
		return '0.0.0.0';
	}
	return $ip;
}

/**
 * One-way hash of IP + site salt.
 *
 * @param string $ip IP.
 * @return string
 */
function noaway_contact_ip_hash( $ip ) {
	return hash( 'sha256', (string) $ip . '|' . wp_salt( 'nonce' ) );
}

/**
 * Rate-limit check.
 *
 * @param string $ip_hash Hashed IP.
 * @return true|WP_Error
 */
function noaway_contact_check_rate_limit( $ip_hash ) {
	$key   = 'noaway_cf_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	if ( $count >= (int) NOAWAY_CONTACT_RATE_LIMIT ) {
		return new WP_Error( 'rate_limited', 'Too many requests.' );
	}
	return true;
}

/**
 * Bump rate-limit counter after an accepted attempt.
 *
 * @param string $ip_hash Hashed IP.
 */
function noaway_contact_bump_rate_limit( $ip_hash ) {
	$key   = 'noaway_cf_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	set_transient( $key, $count + 1, (int) NOAWAY_CONTACT_RATE_WINDOW );
}

/**
 * Verify Google reCAPTCHA v2 when secret is configured.
 *
 * @param string $token Response token.
 * @return bool
 */
function noaway_contact_verify_recaptcha( $token ) {
	$site_key   = defined( 'NOAWAY_RECAPTCHA_SITE_KEY' ) && NOAWAY_RECAPTCHA_SITE_KEY;
	$secret_key = defined( 'NOAWAY_RECAPTCHA_SECRET_KEY' ) && NOAWAY_RECAPTCHA_SECRET_KEY;
	if ( ! $site_key && ! $secret_key ) {
		return true;
	}
	if ( ! $secret_key ) {
		return false;
	}
	$token = is_string( $token ) ? trim( $token ) : '';
	if ( $token === '' ) {
		return false;
	}
	$response = wp_remote_post(
		'https://www.google.com/recaptcha/api/siteverify',
		array(
			'timeout' => 10,
			'body'    => array(
				'secret'   => NOAWAY_RECAPTCHA_SECRET_KEY,
				'response' => $token,
				'remoteip' => noaway_contact_client_ip(),
			),
		)
	);
	if ( is_wp_error( $response ) ) {
		return false;
	}
	$body = json_decode( (string) wp_remote_retrieve_body( $response ), true );
	return is_array( $body ) && ! empty( $body['success'] );
}

/**
 * Redirect back to the contact page with a status query arg.
 *
 * @param string $status sent|error.
 */
function noaway_contact_redirect( $status ) {
	$url = function_exists( 'noaway_contact_page_url' ) ? noaway_contact_page_url() : home_url( '/contacts/' );
	$url = add_query_arg( 'contact', $status, $url );
	wp_safe_redirect( $url );
	exit;
}

/**
 * Build HTML auto-reply body (English).
 *
 * @param string $name Sender name.
 * @return string
 */
function noaway_contact_auto_reply_html( $name ) {
	$brand   = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.brand', 'NoAway' ) : 'NoAway';
	$company = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.company', 'OLIVEE SRLS' ) : 'OLIVEE SRLS';
	$support = noaway_contact_support_email();
	$logo    = esc_url( noaway_contact_email_logo_url() );
	$site    = esc_url( home_url( '/' ) );
	$help    = esc_url( function_exists( 'noaway_help_page_url' ) ? noaway_help_page_url() : home_url( '/help/' ) );
	$first   = trim( (string) $name );
	if ( $first !== '' ) {
		$parts = preg_split( '/\s+/', $first );
		$first = is_array( $parts ) && isset( $parts[0] ) ? $parts[0] : $first;
	}
	$greeting = $first !== ''
		? sprintf( 'Hi %s,', esc_html( $first ) )
		: 'Hi,';

	$primary = '#5851ec';

	ob_start();
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>We've received your message</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#0f172a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f1f5f9;padding:32px 16px;">
	<tr>
		<td align="center">
			<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:560px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
				<tr>
					<td style="padding:28px 32px 16px;text-align:center;border-bottom:1px solid #e2e8f0;">
						<a href="<?php echo $site; ?>" style="text-decoration:none;">
							<img src="<?php echo $logo; ?>" width="64" height="64" alt="<?php echo esc_attr( $brand ); ?>" style="display:inline-block;border:0;border-radius:12px;">
						</a>
						<div style="margin-top:12px;font-size:20px;font-weight:800;letter-spacing:-0.02em;color:#0f172a;"><?php echo esc_html( $brand ); ?></div>
						<div style="margin-top:4px;font-size:12px;color:#64748b;"><?php echo esc_html( $company ); ?></div>
					</td>
				</tr>
				<tr>
					<td style="padding:28px 32px 8px;font-size:16px;line-height:1.6;color:#334155;">
						<p style="margin:0 0 16px;"><?php echo $greeting; ?></p>
						<p style="margin:0 0 16px;">Thank you for contacting <?php echo esc_html( $brand ); ?> Support. We have received your request and it is now in our queue.</p>
						<p style="margin:0 0 16px;">Our team will get back to you as soon as possible. You do not need to resend this message.</p>
						<p style="margin:0 0 16px;">In the meantime, you may find answers in our <a href="<?php echo $help; ?>" style="color:<?php echo esc_attr( $primary ); ?>;font-weight:600;text-decoration:none;">Help Center</a>.</p>
						<p style="margin:0;">— The <?php echo esc_html( $brand ); ?> team</p>
					</td>
				</tr>
				<tr>
					<td style="padding:20px 32px 28px;font-size:12px;line-height:1.5;color:#94a3b8;border-top:1px solid #e2e8f0;">
						<?php echo esc_html( $brand ); ?> · <?php echo esc_html( $company ); ?><br>
						<a href="mailto:<?php echo esc_attr( $support ); ?>" style="color:<?php echo esc_attr( $primary ); ?>;text-decoration:none;"><?php echo esc_html( $support ); ?></a>
						· <a href="<?php echo $site; ?>" style="color:<?php echo esc_attr( $primary ); ?>;text-decoration:none;">noaway.app</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
	<?php
	return (string) ob_get_clean();
}

/**
 * Send HTML auto-reply to the user.
 *
 * @param string $to   User email.
 * @param string $name User name.
 * @return bool
 */
function noaway_contact_send_auto_reply( $to, $name ) {
	$support = noaway_contact_support_email();
	$brand   = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.brand', 'NoAway' ) : 'NoAway';
	$subject = "We've received your message — {$brand} Support";
	$html    = noaway_contact_auto_reply_html( $name );
	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $brand . ' Support <' . $support . '>',
		'Reply-To: ' . $support,
	);
	$sent = wp_mail( $to, $subject, $html, $headers );
	return (bool) $sent;
}

/**
 * Notify support inbox of a new contact submission.
 *
 * @param array{name:string,email:string,topic:string,subject:string,message:string} $data Form data.
 * @return bool
 */
function noaway_contact_send_support_notice( array $data ) {
	$support = noaway_contact_support_email();
	$brand   = function_exists( 'noaway_fact' ) ? (string) noaway_fact( 'publisher.brand', 'NoAway' ) : 'NoAway';
	$topic   = $data['topic'];
	$sub     = $data['subject'] !== '' ? $data['subject'] : '(no subject)';
	$subject = "[{$brand} Contact] {$topic}: {$sub}";

	$body  = "New contact form submission\n\n";
	$body .= 'Name: ' . $data['name'] . "\n";
	$body .= 'Email: ' . $data['email'] . "\n";
	$body .= 'Topic: ' . $data['topic'] . "\n";
	$body .= 'Subject: ' . $sub . "\n\n";
	$body .= "Message:\n" . $data['message'] . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: ' . $brand . ' Website <' . $support . '>',
		'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>',
	);

	return (bool) wp_mail( $support, $subject, $body, $headers );
}

/**
 * Process contact form POST on template_redirect.
 */
function noaway_contact_handle_submit() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( empty( $_POST['noaway_contact_form'] ) ) {
		return;
	}
	if ( empty( $_POST['noaway_contact_submit'] ) && empty( $_POST['noaway_contact_nonce'] ) ) {
		return;
	}

	$ip_hash = noaway_contact_ip_hash( noaway_contact_client_ip() );

	// Honeypot: bots fill this; humans leave empty — silent success.
	$honeypot = isset( $_POST['contact_website'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_website'] ) ) : '';
	if ( $honeypot !== '' ) {
		noaway_contact_bump_rate_limit( $ip_hash );
		noaway_contact_redirect( 'sent' );
	}

	if ( ! isset( $_POST['noaway_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['noaway_contact_nonce'] ) ), 'noaway_contact' ) ) {
		noaway_contact_redirect( 'error' );
	}

	$rate = noaway_contact_check_rate_limit( $ip_hash );
	if ( is_wp_error( $rate ) ) {
		noaway_contact_redirect( 'error' );
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$topic   = isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( $name === '' || ! is_email( $email ) || $message === '' ) {
		noaway_contact_redirect( 'error' );
	}
	if ( ! in_array( $topic, noaway_contact_allowed_topics(), true ) ) {
		noaway_contact_redirect( 'error' );
	}

	$recaptcha = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
	if ( ! noaway_contact_verify_recaptcha( $recaptcha ) ) {
		noaway_contact_redirect( 'error' );
	}

	$data = array(
		'name'    => $name,
		'email'   => $email,
		'topic'   => $topic,
		'subject' => $subject,
		'message' => $message,
	);

	$notice_ok = noaway_contact_send_support_notice( $data );
	if ( ! $notice_ok ) {
		noaway_contact_redirect( 'error' );
	}

	// Best-effort confirmation to the sender; support already has the ticket.
	noaway_contact_send_auto_reply( $email, $name );
	noaway_contact_bump_rate_limit( $ip_hash );
	noaway_contact_redirect( 'sent' );
}
add_action( 'template_redirect', 'noaway_contact_handle_submit', 5 );
