<?php
/**
 * TCP Inter – SEO: meta description, Open Graph, Twitter Card, Schema.org
 */
defined('ABSPATH') || exit;

/* ---------- Meta description + canonical ---------- */
function tcp_meta_tags() {
    $site_name  = 'TCP Inter';
    $separator  = '–';

    // Per-page description
    if (is_front_page()) {
        $desc  = 'TCP Inter, entreprise de nettoyage professionnelle en Île-de-France. Bureaux, fin de chantier, domicile. Devis gratuit sous 24h. Bobigny (93).';
        $title = 'TCP Inter – Entreprise de nettoyage professionnel Île-de-France';
        $url   = home_url('/');
    } elseif (is_page('devis')) {
        $desc  = 'Demandez votre devis gratuit en ligne. TCP Inter intervient en Île-de-France pour le nettoyage de bureaux, chantiers et domiciles. Réponse sous 24h.';
        $title = 'Devis gratuit ' . $separator . ' TCP Inter';
        $url   = get_permalink();
    } else {
        $desc  = get_bloginfo('description') ?: 'TCP Inter – Nettoyage professionnel en Île-de-France.';
        $title = wp_get_document_title();
        $url   = get_permalink() ?: home_url('/');
    }

    $img = get_template_directory_uri() . '/assets/images/og-image.png';

    echo "\n<!-- SEO -->\n";
    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";

    echo "\n<!-- Open Graph -->\n";
    echo '<meta property="og:type"        content="website">' . "\n";
    echo '<meta property="og:url"         content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:title"       content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:image"       content="' . esc_url($img) . '">' . "\n";
    echo '<meta property="og:locale"      content="fr_FR">' . "\n";
    echo '<meta property="og:site_name"   content="' . esc_attr($site_name) . '">' . "\n";

    echo "\n<!-- Twitter Card -->\n";
    echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"       content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta name="twitter:image"       content="' . esc_url($img) . '">' . "\n";
}
add_action('wp_head', 'tcp_meta_tags', 1);

/* ---------- Schema.org LocalBusiness ---------- */
function tcp_schema_org() {
    if (!is_front_page()) return;

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'LocalBusiness',
        'name'            => 'TCP Inter',
        'description'     => 'Entreprise de nettoyage professionnel en Île-de-France. Nettoyage de bureaux, fin de chantier, domicile.',
        'url'             => home_url('/'),
        'telephone'       => '+33644072880',
        'email'           => 'contact@tcpinter.com',
        'priceRange'      => '€€',
        'areaServed'      => 'Île-de-France',
        'address'         => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => '7 rue Voltaire',
            'addressLocality' => 'Bobigny',
            'postalCode'      => '93000',
            'addressCountry'  => 'FR',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 48.9092,
            'longitude' => 2.4396,
        ],
        'openingHoursSpecification' => [
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                'opens'     => '07:00',
                'closes'    => '20:00',
            ],
        ],
        'image'           => get_template_directory_uri() . '/assets/images/og-image.png',
        'sameAs'          => [],
    ];

    echo "\n<!-- Schema.org LocalBusiness -->\n";
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}
add_action('wp_head', 'tcp_schema_org', 2);
