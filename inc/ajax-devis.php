<?php
/**
 * TCP Inter — AJAX handler for devis form
 * Génère un proforma Excel et l'envoie par email
 */

defined('ABSPATH') || exit;

function tcp_devis_submit_handler() {
    ob_start(); // Capture toute sortie parasite (notices, warnings) pour garder une réponse JSON propre

    // Verify nonce
    if (!check_ajax_referer('tcp_devis_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'Requête non autorisée.'], 403);
    }

    // Sanitize inputs
    $ville           = sanitize_text_field($_POST['ville']            ?? '');
    $date            = sanitize_text_field($_POST['date']             ?? '');
    $notes           = sanitize_textarea_field($_POST['notes']        ?? '');
    $prenom          = sanitize_text_field($_POST['prenom']           ?? '');
    $nom             = sanitize_text_field($_POST['nom']              ?? '');
    $email           = sanitize_email($_POST['email']                 ?? '');
    $phone           = sanitize_text_field($_POST['phone']            ?? '');
    $type_prestation = sanitize_text_field($_POST['type_prestation']  ?? '');
    $surface         = (float) ($_POST['surface']                     ?? 0);

    // Validate required
    if (empty($ville) || empty($prenom) || empty($nom) || empty($email) || empty($phone) || empty($type_prestation) || $surface <= 0) {
        wp_send_json_error(['message' => 'Tous les champs obligatoires doivent être remplis.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Adresse e-mail invalide.']);
    }

    // Validate type prestation
    $types_valides = ['bureaux', 'parties_communes', 'commerces', 'entrepots', 'apres_chantier', 'vitrerie', 'desinfection'];
    if (!in_array($type_prestation, $types_valides, true)) {
        wp_send_json_error(['message' => 'Type de prestation invalide.']);
    }

    // Handle file uploads
    $attachment_ids = [];
    $uploaded_files = [];

    if (!empty($_FILES['media']['name'][0])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $allowed_types = ['image/jpeg', 'image/png', 'video/mp4'];
        $max_size      = 20 * 1024 * 1024;

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
                    $uploaded_files[] = $upload['file'];
                }
            }
        }
    }

    // Charger générateur proforma
    require_once get_template_directory() . '/inc/proforma-generator.php';

    $prix_m2   = tcp_get_prix_m2($type_prestation);
    $total_ht  = round($surface * $prix_m2, 2);
    $tva       = round($total_ht * 0.10, 2);
    $total_ttc = round($total_ht + $tva, 2);
    $label_type = tcp_get_prestation_label($type_prestation);

    // Générer le proforma Excel
    $proforma_path = null;
    try {
        $proforma_path = tcp_generate_proforma([
            'prenom'          => $prenom,
            'nom'             => $nom,
            'email'           => $email,
            'phone'           => $phone,
            'ville'           => $ville,
            'date'            => $date,
            'type_prestation' => $type_prestation,
            'surface'         => $surface,
            'notes'           => $notes,
        ]);
    } catch (\Throwable $e) {
        error_log('TCP Inter - Erreur proforma : ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    }

    // Save to database
    $post_id = wp_insert_post([
        'post_type'   => 'tcp_devis',
        'post_title'  => sanitize_text_field($prenom . ' ' . $nom . ' - ' . $ville),
        'post_status' => 'publish',
    ]);

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_devis_prenom',    $prenom);
        update_post_meta($post_id, '_devis_nom',       $nom);
        update_post_meta($post_id, '_devis_email',     $email);
        update_post_meta($post_id, '_devis_phone',     $phone);
        update_post_meta($post_id, '_devis_ville',     $ville);
        update_post_meta($post_id, '_devis_date',      $date);
        update_post_meta($post_id, '_devis_type',      $type_prestation);
        update_post_meta($post_id, '_devis_surface',   $surface);
        update_post_meta($post_id, '_devis_prix_m2',   $prix_m2);
        update_post_meta($post_id, '_devis_total_ht',  $total_ht);
        update_post_meta($post_id, '_devis_total_ttc', $total_ttc);
        update_post_meta($post_id, '_devis_notes',     $notes);
        update_post_meta($post_id, '_devis_created',   current_time('mysql'));
        if ($proforma_path) {
            update_post_meta($post_id, '_devis_proforma_path', $proforma_path);
        }
    }

    // Build email interne
    $to      = 'contact@tcpinter.com';
    $subject = sprintf('[TCP Inter] Nouvelle demande de devis - %s %s', $prenom, $nom);

    $body  = "NOUVELLE DEMANDE DE DEVIS - TCP INTER\n";
    $body .= str_repeat('=', 50) . "\n\n";
    $body .= "CLIENT\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= sprintf("  Nom           : %s %s\n", $prenom, strtoupper($nom));
    $body .= sprintf("  Email         : %s\n", $email);
    $body .= sprintf("  Telephone     : +33 %s\n\n", $phone);
    $body .= "PRESTATION\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= sprintf("  Type          : %s\n", $label_type);
    $body .= sprintf("  Ville         : %s\n", $ville);
    $body .= sprintf("  Surface       : %s m2\n", number_format($surface, 0, ',', ' '));
    $body .= sprintf("  Date souhaitee: %s\n\n", $date ? date('d/m/Y', strtotime($date)) : 'Non precisee');
    $body .= "ESTIMATION\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= sprintf("  Prix unitaire : %s EUR/m2\n", number_format($prix_m2, 2, ',', ' '));
    $body .= sprintf("  Total HT      : %s EUR\n", number_format($total_ht, 2, ',', ' '));
    $body .= sprintf("  TVA 10%%       : %s EUR\n", number_format($tva, 2, ',', ' '));
    $body .= sprintf("  TOTAL TTC     : %s EUR\n\n", number_format($total_ttc, 2, ',', ' '));
    if (!empty($notes)) {
        $body .= "NOTES : " . $notes . "\n\n";
    }
    if (!empty($uploaded_files)) {
        $body .= sprintf("MEDIAS : %d fichier(s) en piece jointe\n\n", count($uploaded_files));
    }
    $body .= str_repeat('=', 50) . "\n";
    $body .= "Le proforma Excel est en piece jointe.\n";
    $body .= "Vous pouvez le modifier et l envoyer manuellement au client.\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . sanitize_email($email),
    ];

    $attachments = [];
    if ($proforma_path && file_exists($proforma_path)) {
        $attachments[] = $proforma_path;
    }
    foreach ($uploaded_files as $fp) {
        if (file_exists($fp)) $attachments[] = $fp;
    }

    $sent = wp_mail($to, $subject, $body, $headers, $attachments);

    // Email confirmation client
    $conf_subject = 'TCP Inter - Confirmation de votre demande de devis';
    $conf_body    = sprintf("Bonjour %s,\n\n", $prenom);
    $conf_body   .= "Nous avons bien recu votre demande de devis et nous vous contacterons sous 24h.\n\n";
    $conf_body   .= "Recapitulatif :\n";
    $conf_body   .= str_repeat('-', 40) . "\n";
    $conf_body   .= sprintf("  Prestation    : %s\n", $label_type);
    $conf_body   .= sprintf("  Ville         : %s\n", $ville);
    $conf_body   .= sprintf("  Surface       : %s m2\n", number_format($surface, 0, ',', ' '));
    $conf_body   .= sprintf("  Estimation HT : %s EUR\n", number_format($total_ht, 2, ',', ' '));
    $conf_body   .= sprintf("  Telephone     : +33 %s\n\n", $phone);
    $conf_body   .= "Cette estimation est indicative. Le devis definitif vous sera envoye apres etude.\n\n";
    $conf_body   .= "Cordialement,\n";
    $conf_body   .= "L equipe TCP Inter\n";
    $conf_body   .= "7 rue Voltaire, 93000 Bobigny\n";
    $conf_body   .= "Tel : +33 06 44 07 28 80\n";
    $conf_body   .= "contact@tcpinter.com | tcpinter.com";

    wp_mail($email, $conf_subject, $conf_body, ['Content-Type: text/plain; charset=UTF-8']);

    ob_get_clean(); // Vide le buffer avant d'envoyer la réponse JSON

    if ($sent) {
        wp_send_json_success(['message' => 'Votre demande a bien ete envoyee ! Nous vous contacterons sous 24h.']);
    } else {
        wp_send_json_success(['message' => 'Votre demande a bien ete recue ! Nous vous contacterons sous 24h.']);
    }
}

add_action('wp_ajax_tcp_devis_submit',        'tcp_devis_submit_handler');
add_action('wp_ajax_nopriv_tcp_devis_submit', 'tcp_devis_submit_handler');