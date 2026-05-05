<?php
/**
 * TCP Inter – Helper functions
 */

defined('ABSPATH') || exit;

/**
 * Output SVG icons inline
 */
function tcp_icon(string $name, string $classes = ''): void {
    $icons = [
        'check'    => '<path d="M20 6L9 17l-5-5"/>',
        'arrow'    => '<path d="M5 12h14M12 5l7 7-7 7"/>',
        'phone'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 3h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 10.5a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'mail'     => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'location' => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'star'     => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'leaf'     => '<path d="M2 22L16 8M16 2s4 4 4 8-4 4-4 4H8S4 14 8 10s8-8 8-8z"/>',
        'clock'    => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'upload'   => '<polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>',
        'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'linkedin' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
        'instagram'=> '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
        'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
    ];

    $path = $icons[$name] ?? '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>';
    $cls  = $classes ? ' class="' . esc_attr($classes) . '"' : '';
    echo '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/**
 * Get testimonials from CPT or return defaults
 */
function tcp_get_testimonials(): array {
    $query = new WP_Query([
        'post_type'      => 'tcp_testimonial',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if ($query->have_posts()) {
        $items = [];
        while ($query->have_posts()) {
            $query->the_post();
            $items[] = [
                'text'    => get_the_content(),
                'name'    => get_post_meta(get_the_ID(), '_author_name', true) ?: get_the_title(),
                'role'    => get_post_meta(get_the_ID(), '_author_role', true),
                'initial' => mb_strtoupper(mb_substr(get_the_title(), 0, 1)),
                'rating'  => (int) (get_post_meta(get_the_ID(), '_rating', true) ?: 5),
            ];
        }
        wp_reset_postdata();
        return $items;
    }

    // Default fallback testimonials
    return [
        [
            'text'    => "Une équipe extrêmement professionnelle et ponctuelle. La qualité du nettoyage de nos bureaux s'est nettement améliorée depuis que nous travaillons avec TCP Inter.",
            'name'    => 'Jean-Baptiste M.',
            'role'    => 'Directeur de bureaux, Île-de-France',
            'initial' => 'J',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=11',
        ],
        [
            'text'    => "Leur service de remise en état après travaux est à la hauteur ! Impeccable, Résultat et méticuleux, ils ont su s'adapter à nos délais serrés.",
            'name'    => 'Sophie L.',
            'role'    => 'Administratrice de copropriété, Nanterre',
            'initial' => 'S',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=47',
        ],
        [
            'text'    => "Excellent service de nettoyage à domicile. Les agents sont discrets et efficaces, le résultat est toujours parfait. Je recommande vivement TCP Inter.",
            'name'    => 'Marc-Antoine D.',
            'role'    => 'Client particulier, Versailles',
            'initial' => 'M',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=33',
        ],
        [
            'text'    => "TCP Inter assure le nettoyage de nos locaux à Saint-Denis depuis plus d'un an. Sérieux, réactifs et toujours disponibles — exactement ce qu'on attendait.",
            'name'    => 'Clémence B.',
            'role'    => 'Responsable facilities, Saint-Denis',
            'initial' => 'C',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=44',
        ],
        [
            'text'    => "J'ai fait appel à TCP Inter pour un nettoyage de fin de chantier. Travail soigné, délais respectés, équipe agréable. Je les recommande sans hésitation.",
            'name'    => 'Nicolas R.',
            'role'    => "Maître d'œuvre, Créteil",
            'initial' => 'N',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=68',
        ],
        [
            'text'    => "Prestation impeccable pour mon appartement. L'équipe est ponctuelle, professionnelle et le résultat est vraiment au rendez-vous. Merci TCP Inter !",
            'name'    => 'Amélie T.',
            'role'    => 'Cliente particulière, Montreuil',
            'initial' => 'A',
            'rating'  => 5,
            'avatar'  => 'https://i.pravatar.cc/80?img=49',
        ],
    ];
}

/**
 * Get partners from CPT or return image paths
 */
function tcp_get_partners(): array {
    $query = new WP_Query([
        'post_type'      => 'tcp_partner',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
    ]);

    if ($query->have_posts()) {
        $items = [];
        while ($query->have_posts()) {
            $query->the_post();
            $items[] = [
                'name' => get_the_title(),
                'logo' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            ];
        }
        wp_reset_postdata();
        return $items;
    }

    // Default: use theme images
    $uri = get_template_directory_uri() . '/assets/images/';
    return [
        ['name' => 'Malakoff Humanis',              'logo' => $uri . 'malakoff_humanis.png'],
        ['name' => 'Harmonie Mutuelle',              'logo' => $uri . 'harmonie_mutuelle.jpg'],
        ['name' => 'CNP Assurances',                 'logo' => $uri . 'cnp_assurances.png'],
        ['name' => 'Infogreffe',                     'logo' => $uri . 'infogreffe.jpg'],
        ['name' => 'Marché International de Rungis', 'logo' => $uri . 'marche_rungis.png'],
    ];
}

/**
 * Returns the list of cities TCP Inter covers
 */
function tcp_get_cities(): array {
    return [
        'Paris (75)',
        'Bobigny (93)',
        'Nanterre (92)',
        'Créteil (94)',
        'Versailles (78)',
        'Évry (91)',
        'Cergy (95)',
        'Aulnay-sous-Bois',
        'Saint-Denis (93)',
        'Montreuil (93)',
        'Vincennes (94)',
        'Massy (91)',
    ];
}
