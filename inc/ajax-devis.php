<?php
/**
 * TCP Inter – AJAX handler for devis form
 */

defined('ABSPATH') || exit;

function tcp_devis_submit_handler() {
    // Verify nonce
    if (!check_ajax_referer('tcp_devis_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'Requête non autorisée.'], 403);
    }

    // Sanitize inputs
    $ville    = sanitize_text_field($_POST['ville']    ?? '');
    $date     = sanitize_text_field($_POST['date']     ?? '');
    $notes    = sanitize_textarea_field($_POST['notes'] ?? '');
    $prenom   = sanitize_text_field($_POST['prenom']   ?? '');
    $nom      = sanitize_text_field($_POST['nom']      ?? '');
    $email    = sanitize_email($_POST['email']         ?? '');
    $phone    = sanitize_text_field($_POST['phone']    ?? '');

    // Validate required
    if (empty($ville) || empty($prenom) || empty($nom) || empty($email) || empty($phone)) {
        wp_send_json_error(['message' => 'Tous les champs obligatoires doivent être remplis.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Adresse e-mail invalide.']);
    }

    // Handle file upload (optional)
    $attachment_ids = [];
    if (!empty($_FILES['media']['name'][0])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $allowed_types = ['image/jpeg', 'image/png', 'video/mp4'];
        $max_size      = 20 * 1024 * 1024; // 20 MB

        foreach ($_FILES['media']['tmp_name'] as $i => $tmp_name) {
            if (empty($tmp_name)) continue;

            $file_type = mime_content_type($tmp_name);
            $file_size = $_FILES['media']['size'][$i];

            if (!in_array($file_type, $allowed_types, true)) continue;
            if ($file_size > $max_size) continue;

            $file = [
                'name'     => sanitize_file_name($_FILES['media']['name'][$i]),
                'type'     => $file_type,
                'tmp_name' => $tmp_name,
                'error'    => $_FILES['media']['error'][$i],
                'size'     => $file_size,
            ];

            $upload = wp_handle_upload($file, ['test_form' => false]);
            if (!isset($upload['error'])) {
                $attach_id = wp_insert_attachment([
                    'post_mime_type' => $upload['type'],
                    'post_title'     => sanitize_file_name($file['name']),
                    'post_status'    => 'inherit',
                ], $upload['file']);

                if (!is_wp_error($attach_id)) {
                    $attachment_ids[] = $attach_id;
                }
            }
        }
    }

    // Save to database regardless of email result
    $post_id = wp_insert_post([
        'post_type'   => 'tcp_devis',
        'post_title'  => sanitize_text_field($prenom . ' ' . $nom . ' — ' . $ville),
        'post_status' => 'publish',
    ]);

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_devis_prenom',  $prenom);
        update_post_meta($post_id, '_devis_nom',     $nom);
        update_post_meta($post_id, '_devis_email',   $email);
        update_post_meta($post_id, '_devis_phone',   $phone);
        update_post_meta($post_id, '_devis_ville',   $ville);
        update_post_meta($post_id, '_devis_date',    $date);
        update_post_meta($post_id, '_devis_notes',   $notes);
        update_post_meta($post_id, '_devis_created', current_time('mysql'));
    }

    // Build email
    $to      = get_option('admin_email');
    $subject = sprintf('[TCP Inter] Nouvelle demande de devis – %s %s', $prenom, $nom);

    $body  = "Nouvelle demande de devis reçue :\n\n";
    $body .= "Ville         : {$ville}\n";
    $body .= "Date souhaitée: {$date}\n";
    $body .= "Prénom        : {$prenom}\n";
    $body .= "Nom           : {$nom}\n";
    $body .= "Email         : {$email}\n";
    $body .= "Téléphone     : +33 {$phone}\n";
    $body .= "Notes         : {$notes}\n\n";

    if (!empty($attachment_ids)) {
        $body .= "Fichiers joints : " . count($attachment_ids) . " fichier(s) uploadé(s)\n";
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . sanitize_email($email),
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    // Also send confirmation to client
    if ($sent) {
        $conf_subject = 'TCP Inter – Confirmation de votre demande de devis';
        $conf_body    = "Bonjour {$prenom},\n\n";
        $conf_body   .= "Nous avons bien reçu votre demande de devis et nous vous contacterons sous 24h.\n\n";
        $conf_body   .= "Récapitulatif :\n";
        $conf_body   .= "Ville    : {$ville}\n";
        $conf_body   .= "Date     : {$date}\n";
        $conf_body   .= "Téléphone: +33 {$phone}\n\n";
        $conf_body   .= "Cordialement,\nL'équipe TCP Inter\n7 rue Voltaire, 93000 Bobigny\nTél : +33 06 44 07 28 80";

        wp_mail($email, $conf_subject, $conf_body, ['Content-Type: text/plain; charset=UTF-8']);
    }

    if ($sent) {
        wp_send_json_success(['message' => 'Votre demande a bien été envoyée ! Nous vous contacterons sous 24h.']);
    } else {
        wp_send_json_success(['message' => 'Votre demande a bien été reçue ! Nous vous contacterons sous 24h.']);
    }
}

add_action('wp_ajax_tcp_devis_submit',        'tcp_devis_submit_handler');
add_action('wp_ajax_nopriv_tcp_devis_submit', 'tcp_devis_submit_handler');
