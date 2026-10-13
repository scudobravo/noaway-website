<?php
/**
 * Compact “Before you buy” summary under purchase CTAs.
 * Data from inc/noaway-facts.php (license + requirements).
 *
 * @package NoAway
 *
 * @var array{lang?:string} $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lang = 'en';
if ( isset( $args ) && is_array( $args ) && ! empty( $args['lang'] ) ) {
	$lang = (string) $args['lang'];
}
if ( function_exists( 'noaway_i18n_normalize_lang' ) ) {
	$lang = noaway_i18n_normalize_lang( $lang );
}

$price = function_exists( 'noaway_price_label' ) ? noaway_price_label() : (string) noaway_fact( 'license.price_label_current', '€4.99' );
$macos = (string) noaway_fact( 'requirements.macos_min', 'macOS 11 (Big Sur) or later' );
$win   = (string) noaway_fact( 'requirements.windows_min', 'Windows 10/11 (64-bit)' );

$copy = array(
	'en'    => array(
		'title'        => 'Before you buy',
		'platforms'    => 'Mac & Windows: ' . $macos . '; ' . $win,
		'devices'      => (string) noaway_fact( 'license.devices_label', 'One license works on one device.' ),
		'transfer'     => 'Moving to a new computer: contact support with your order email.',
		'updates'      => (string) noaway_fact( 'license.lifetime_updates_short', 'Updates are emailed with a direct download link.' ),
		'requirements' => 'macOS needs Accessibility permission for Keep Active. Process stays in the menu bar / tray (window can close).',
		'support'      => 'Support: support@noaway.app',
		'price'        => 'One-time ' . $price . ' (launch price).',
		'refund'       => 'Not satisfied? Request a refund within 7 days',
		'check_req'    => 'Check requirements',
	),
	'de'    => array(
		'title'        => 'Vor dem Kauf',
		'platforms'    => 'Mac & Windows: ' . $macos . '; ' . $win,
		'devices'      => 'Eine Lizenz gilt für ein Gerät.',
		'transfer'     => 'Wechsel auf einen neuen Computer: Support mit der Kauf-E-Mail kontaktieren.',
		'updates'      => 'Updates kommen per E-Mail mit direktem Download-Link.',
		'requirements' => 'Unter macOS ist die Bedienungshilfen-Berechtigung nötig. Der Prozess bleibt in der Menüleiste / im Infobereich.',
		'support'      => 'Support: support@noaway.app',
		'price'        => 'Einmalig ' . $price . ' (Einführungspreis).',
		'refund'       => 'Nicht zufrieden? Rückerstattung innerhalb von 7 Tagen beantragen',
		'check_req'    => 'Anforderungen prüfen',
	),
	'es'    => array(
		'title'        => 'Antes de comprar',
		'platforms'    => 'Mac y Windows: ' . $macos . '; ' . $win,
		'devices'      => 'Una licencia funciona en un dispositivo.',
		'transfer'     => 'Cambiar a otro equipo: contacta con soporte con el email de compra.',
		'updates'      => 'Las actualizaciones se envían por email con enlace de descarga directo.',
		'requirements' => 'En macOS hace falta el permiso de Accesibilidad. El proceso sigue en la barra de menús / bandeja.',
		'support'      => 'Soporte: support@noaway.app',
		'price'        => 'Pago único ' . $price . ' (precio de lanzamiento).',
		'refund'       => '¿No estás satisfecho? Solicita un reembolso en 7 días',
		'check_req'    => 'Comprobar requisitos',
	),
	'pt-br' => array(
		'title'        => 'Antes de comprar',
		'platforms'    => 'Mac e Windows: ' . $macos . '; ' . $win,
		'devices'      => 'Uma licença funciona em um dispositivo.',
		'transfer'     => 'Trocar de computador: fale com o suporte com o email da compra.',
		'updates'      => 'Atualizações são enviadas por email com link direto de download.',
		'requirements' => 'No macOS é preciso a permissão de Acessibilidade. O processo fica na barra de menus / bandeja.',
		'support'      => 'Suporte: support@noaway.app',
		'price'        => 'Pagamento único ' . $price . ' (preço de lançamento).',
		'refund'       => 'Não ficou satisfeito? Peça reembolso em até 7 dias',
		'check_req'    => 'Verificar requisitos',
	),
	'fr'    => array(
		'title'        => 'Avant d’acheter',
		'platforms'    => 'Mac et Windows : ' . $macos . '; ' . $win,
		'devices'      => 'Une licence fonctionne sur un appareil.',
		'transfer'     => 'Changer d’ordinateur : contactez le support avec l’email d’achat.',
		'updates'      => 'Les mises à jour sont envoyées par e-mail avec un lien de téléchargement direct.',
		'requirements' => 'Sur macOS, l’autorisation Accessibilité est requise. Le processus reste dans la barre des menus / la zone de notification.',
		'support'      => 'Support : support@noaway.app',
		'price'        => 'Achat unique ' . $price . ' (prix de lancement).',
		'refund'       => 'Pas satisfait ? Demandez un remboursement sous 7 jours',
		'check_req'    => 'Vérifier les prérequis',
	),
);

$c        = isset( $copy[ $lang ] ) ? $copy[ $lang ] : $copy['en'];
$help_req = function_exists( 'noaway_help_page_url' ) ? noaway_help_page_url() . '#requirements' : home_url( '/help/#requirements' );
$contact  = function_exists( 'noaway_contact_page_url' ) ? noaway_contact_page_url() : home_url( '/contacts/' );

$rows = array(
	array( 'icon' => 'devices', 'text' => $c['platforms'] ),
	array( 'icon' => 'phonelink_lock', 'text' => $c['devices'] ),
	array( 'icon' => 'swap_horiz', 'text' => $c['transfer'] ),
	array( 'icon' => 'mail', 'text' => $c['updates'] ),
	array( 'icon' => 'settings_accessibility', 'text' => $c['requirements'] ),
	array( 'icon' => 'support_agent', 'text' => $c['support'] ),
	array( 'icon' => 'payments', 'text' => $c['price'] ),
);
?>
<aside class="noaway-before-you-buy mt-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4 sm:p-5 text-left max-w-md" aria-labelledby="noaway-before-buy-heading">
	<h2 id="noaway-before-buy-heading" class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-3"><?php echo esc_html( $c['title'] ); ?></h2>
	<ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400 leading-snug">
		<?php foreach ( $rows as $row ) : ?>
		<li class="flex items-start gap-2">
			<span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5" aria-hidden="true"><?php echo esc_html( $row['icon'] ); ?></span>
			<span><?php echo esc_html( $row['text'] ); ?></span>
		</li>
		<?php endforeach; ?>
	</ul>
	<p class="mt-3 text-sm">
		<a href="<?php echo esc_url( $help_req ); ?>" class="text-primary font-semibold hover:underline"><?php echo esc_html( $c['check_req'] ); ?></a>
		<span class="text-slate-400 mx-1.5" aria-hidden="true">·</span>
		<a href="<?php echo esc_url( $contact ); ?>" class="text-primary font-semibold hover:underline"><?php echo esc_html( $c['refund'] ); ?></a>
	</p>
</aside>
