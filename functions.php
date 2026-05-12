<?php
/**
 * TCP Inter Theme – functions.php
 *
 * Design & Development: HeyHappy Digital Agency
 * heyhappyproject@gmail.com | +229 01 68 62 87 40
 * https://happyazondekon.github.io/
 */

defined('ABSPATH') || exit;

// Composer autoload (PhpSpreadsheet etc.)
$vendor_autoload = get_template_directory() . '/vendor/autoload.php';
if (file_exists($vendor_autoload)) {
    require_once $vendor_autoload;
}

/* ---------- Theme setup ---------- */
function tcpinter_setup() {
    load_theme_textdomain('tcpinter', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Menu principal', 'tcpinter'),
        'footer'  => __('Menu footer', 'tcpinter'),
    ]);
}
add_action('after_setup_theme', 'tcpinter_setup');

/* ---------- Enqueue assets ---------- */
function tcpinter_assets() {
    $v = wp_get_theme()->get('Version');
    $uri = get_template_directory_uri();

    // Google Fonts
    wp_enqueue_style('tcpinter-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap',
        [], null
    );

    // Leaflet CSS
    wp_enqueue_style('leaflet',
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        [], '1.9.4'
    );

    // Theme CSS
    wp_enqueue_style('tcpinter-main',    $uri . '/assets/css/main.css',    ['tcpinter-fonts'], $v);
    wp_enqueue_style('tcpinter-header',  $uri . '/assets/css/header.css',  ['tcpinter-main'], $v);
    wp_enqueue_style('tcpinter-hero',    $uri . '/assets/css/hero.css',    ['tcpinter-main'], $v);
    wp_enqueue_style('tcpinter-sections',$uri . '/assets/css/sections.css',['tcpinter-main'], $v);
    wp_enqueue_style('tcpinter-cookies',  $uri . '/assets/css/cookies.css',  ['tcpinter-main'], $v);

    if (is_page_template('page-devis.php')) {
        wp_enqueue_style('tcpinter-devis', $uri . '/assets/css/devis.css', ['tcpinter-main'], $v);
    }
    // Leaflet JS
    wp_enqueue_script('leaflet',
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
        [], '1.9.4', true
    );

    // Theme JS
    wp_enqueue_script('tcpinter-main',
        $uri . '/assets/js/main.js',
        [], $v, true
    );
    wp_enqueue_script('tcpinter-cookies',
        $uri . '/assets/js/cookies.js',
        [], $v, true
    );

    // Map JS (only on front page or pages with map)
    if (is_front_page() || is_page('accueil')) {
        wp_enqueue_script('tcpinter-map',
            $uri . '/assets/js/map.js',
            ['leaflet'], $v, true
        );
    }

    // Devis JS
    if (is_page_template('page-devis.php')) {
        wp_enqueue_script('tcpinter-devis',
            $uri . '/assets/js/devis.js',
            [], $v, true
        );
        wp_localize_script('tcpinter-devis', 'tcpAjax', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('tcp_devis_nonce'),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'tcpinter_assets');

/* ---------- Disable emoji scripts ---------- */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* ---------- SMTP Gmail via PHPMailer ---------- */
add_action('phpmailer_init', function ($phpmailer) {
    if (!defined('TCP_SMTP_HOST')) return;
    $phpmailer->isSMTP();
    $phpmailer->Host       = TCP_SMTP_HOST;
    $phpmailer->Port       = TCP_SMTP_PORT;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Username   = TCP_SMTP_USER;
    $phpmailer->Password   = TCP_SMTP_PASS;
    $phpmailer->setFrom(TCP_SMTP_FROM, TCP_SMTP_FROM_NAME, false);
});

// Forcer l'adresse From pour WordPress (filtre wp_mail_from)
add_filter('wp_mail_from',      function () { return defined('TCP_SMTP_FROM')      ? TCP_SMTP_FROM      : 'wordpress@localhost'; });
add_filter('wp_mail_from_name', function () { return defined('TCP_SMTP_FROM_NAME') ? TCP_SMTP_FROM_NAME : 'WordPress'; });

/* ---------- AJAX: Devis form ---------- */
require_once get_template_directory() . '/inc/ajax-devis.php';

/* ---------- Custom post types ---------- */
require_once get_template_directory() . '/inc/post-types.php';

/* ---------- Helper functions ---------- */
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/fallback-menu.php';
require_once get_template_directory() . '/inc/seo.php';

/* ---------- Widget areas ---------- */
function tcpinter_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Widget 1', 'tcpinter'),
        'id'            => 'footer-1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'tcpinter_widgets_init');

/* ---------- Security headers ---------- */
function tcpinter_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'tcpinter_security_headers');

/* ---------- Disable XML-RPC ---------- */
add_filter('xmlrpc_enabled', '__return_false');

/* ---------- Remove WP version from head ---------- */
remove_action('wp_head', 'wp_generator');
