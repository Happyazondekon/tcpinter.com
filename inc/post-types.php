<?php
/**
 * TCP Inter – Custom Post Types
 */

defined('ABSPATH') || exit;

/* ---------- Témoignages ---------- */
function tcp_register_testimonial_cpt() {
    register_post_type('tcp_testimonial', [
        'labels' => [
            'name'          => 'Témoignages',
            'singular_name' => 'Témoignage',
            'add_new_item'  => 'Ajouter un témoignage',
            'edit_item'     => 'Modifier le témoignage',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'menu_position' => 25,
    ]);
}
add_action('init', 'tcp_register_testimonial_cpt');

/* ---------- Partenaires ---------- */
function tcp_register_partner_cpt() {
    register_post_type('tcp_partner', [
        'labels' => [
            'name'          => 'Partenaires',
            'singular_name' => 'Partenaire',
            'add_new_item'  => 'Ajouter un partenaire',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => ['title', 'thumbnail'],
        'menu_position' => 26,
    ]);
}
add_action('init', 'tcp_register_partner_cpt');

/* ---------- Demandes de devis ---------- */
function tcp_register_devis_cpt() {
    register_post_type('tcp_devis', [
        'labels' => [
            'name'          => 'Demandes de devis',
            'singular_name' => 'Demande de devis',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-email-alt',
        'supports'      => ['title', 'custom-fields'],
        'menu_position' => 27,
        'capabilities'  => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'  => true,
    ]);
}
add_action('init', 'tcp_register_devis_cpt');
