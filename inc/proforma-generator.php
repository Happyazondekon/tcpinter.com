<?php
/**
 * TCP Inter — Générateur de proforma Excel
 * Utilise PhpSpreadsheet
 */

defined('ABSPATH') || exit;

require_once get_template_directory() . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

/**
 * Retourne le libellé d'un type de prestation
 */
function tcp_get_prestation_label(string $type): string {
    $labels = [
        'bureaux'         => 'Bureaux / Locaux tertiaires',
        'parties_communes'=> 'Parties communes (copropriété)',
        'commerces'       => 'Commerces / Boutiques',
        'entrepots'       => 'Entrepôts / Industriel',
        'apres_chantier'  => 'Après chantier (remise en état)',
        'vitrerie'        => 'Vitrerie (intérieur + extérieur)',
        'desinfection'    => 'Désinfection / Traitement',
    ];
    return $labels[$type] ?? $type;
}

/**
 * Retourne le prix par m² pour un type de prestation
 */
function tcp_get_prix_m2(string $type): float {
    $prix = [
        'bureaux'         => 1.10,
        'parties_communes'=> 0.75,
        'commerces'       => 1.20,
        'entrepots'       => 0.60,
        'apres_chantier'  => 5.50,
        'vitrerie'        => 9.00,
        'desinfection'    => 3.50,
    ];
    return $prix[$type] ?? 0.0;
}

/**
 * Génère un proforma Excel et retourne le chemin du fichier temporaire
 *
 * @param array $data  Données du formulaire + calculs
 * @return string      Chemin du fichier .xlsx temporaire
 */
function tcp_generate_proforma(array $data): string {

    // ── Données ──────────────────────────────────────────────────────────────
    $prenom          = $data['prenom']           ?? '';
    $nom             = $data['nom']              ?? '';
    $email           = $data['email']            ?? '';
    $phone           = $data['phone']            ?? '';
    $ville           = $data['ville']            ?? '';
    $date_prestation = $data['date']             ?? '';
    $type_prestation = $data['type_prestation']  ?? '';
    $surface         = (float) ($data['surface'] ?? 0);
    $notes           = $data['notes']            ?? '';

    $prix_m2         = tcp_get_prix_m2($type_prestation);
    $total_ht        = round($surface * $prix_m2, 2);
    $tva_rate        = 0.10; // TVA 10% (taux réduit nettoyage)
    $tva_montant     = round($total_ht * $tva_rate, 2);
    $total_ttc       = round($total_ht + $tva_montant, 2);

    $numero          = 'PRF-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
    $date_emission   = date('d/m/Y');

    $label_prestation = tcp_get_prestation_label($type_prestation);

    // ── Couleurs TCP Inter ────────────────────────────────────────────────────
    $bleu_marine  = '00365F'; // Primary
    $bleu_clair   = 'E8F4FD'; // Surface
    $gris_clair   = 'F8FAFC';
    $blanc        = 'FFFFFF';
    $texte_gris   = '6B7280';
    $vert_success = '16A34A';

    // ── Spreadsheet ───────────────────────────────────────────────────────────
    $spreadsheet = new Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Proforma');

    // Largeur des colonnes
    $sheet->getColumnDimension('A')->setWidth(3);
    $sheet->getColumnDimension('B')->setWidth(28);
    $sheet->getColumnDimension('C')->setWidth(32);
    $sheet->getColumnDimension('D')->setWidth(14);
    $sheet->getColumnDimension('E')->setWidth(14);
    $sheet->getColumnDimension('F')->setWidth(16);
    $sheet->getColumnDimension('G')->setWidth(3);

    // ── HEADER FOND ───────────────────────────────────────────────────────────
    $sheet->mergeCells('A1:G4');
    $sheet->getStyle('A1:G4')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setRGB($bleu_marine);
    $sheet->getRowDimension('1')->setRowHeight(10);
    $sheet->getRowDimension('2')->setRowHeight(40);
    $sheet->getRowDimension('3')->setRowHeight(20);
    $sheet->getRowDimension('4')->setRowHeight(10);

    // Logo (si disponible)
    $logo_path = get_template_directory() . '/assets/images/logo_tcp_inter.png';
    if (file_exists($logo_path)) {
        $drawing = new Drawing();
        $drawing->setName('Logo TCP Inter');
        $drawing->setPath($logo_path);
        $drawing->setHeight(50);
        $drawing->setCoordinates('B2');
        $drawing->setWorksheet($sheet);
    }

    // Titre PROFORMA à droite du header
    $sheet->setCellValue('E2', 'DEVIS PROFORMA');
    $sheet->getStyle('E2')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 16, 'color' => ['rgb' => $blanc]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
    ]);
    $sheet->mergeCells('E2:F2');

    $sheet->setCellValue('E3', 'N° ' . $numero);
    $sheet->getStyle('E3')->applyFromArray([
        'font'      => ['size' => 9, 'color' => ['rgb' => 'BFD9EE']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
    ]);
    $sheet->mergeCells('E3:F3');

    // ── INFOS ÉMETTEUR ────────────────────────────────────────────────────────
    $sheet->getRowDimension('5')->setRowHeight(8);
    $sheet->getRowDimension('6')->setRowHeight(18);
    $sheet->getRowDimension('7')->setRowHeight(15);
    $sheet->getRowDimension('8')->setRowHeight(15);
    $sheet->getRowDimension('9')->setRowHeight(15);
    $sheet->getRowDimension('10')->setRowHeight(15);
    $sheet->getRowDimension('11')->setRowHeight(8);

    // Émetteur (gauche)
    $sheet->setCellValue('B6', 'TCP INTER SAS');
    $sheet->getStyle('B6')->applyFromArray([
        'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => $bleu_marine]],
    ]);

    $emetteur = [
        'B7'  => '7 rue Voltaire, 93000 Bobigny',
        'B8'  => 'Île-de-France, France',
        'B9'  => 'Tél : +33 06 44 07 28 80',
        'B10' => 'contact@tcpinter.com  |  tcpinter.com',
    ];
    foreach ($emetteur as $cell => $val) {
        $sheet->setCellValue($cell, $val);
        $sheet->getStyle($cell)->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => $texte_gris]],
        ]);
    }

    // Date d'émission (droite)
    $sheet->setCellValue('E6', 'Date d\'émission :');
    $sheet->setCellValue('F6', $date_emission);
    $sheet->getStyle('E6')->applyFromArray(['font' => ['size' => 9, 'color' => ['rgb' => $texte_gris]]]);
    $sheet->getStyle('F6')->applyFromArray(['font' => ['size' => 9, 'bold' => true, 'color' => ['rgb' => $bleu_marine]]]);

    $sheet->setCellValue('E7', 'Valable 30 jours');
    $sheet->getStyle('E7')->applyFromArray(['font' => ['size' => 9, 'italic' => true, 'color' => ['rgb' => $texte_gris]]]);

    // ── CLIENT ────────────────────────────────────────────────────────────────
    $sheet->getRowDimension('12')->setRowHeight(5);
    $sheet->getRowDimension('13')->setRowHeight(18);
    $sheet->mergeCells('B13:F13');
    $sheet->setCellValue('B13', 'CLIENT');
    $sheet->getStyle('B13:F13')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => $blanc]],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bleu_marine]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
    ]);

    $sheet->getRowDimension('14')->setRowHeight(15);
    $sheet->getRowDimension('15')->setRowHeight(15);
    $sheet->getRowDimension('16')->setRowHeight(15);
    $sheet->getRowDimension('17')->setRowHeight(15);

    $sheet->mergeCells('B14:F14');
    $sheet->setCellValue('B14', $prenom . ' ' . strtoupper($nom));
    $sheet->getStyle('B14')->applyFromArray(['font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => $bleu_marine]]]);

    $sheet->mergeCells('B15:F15');
    $sheet->setCellValue('B15', 'Ville : ' . $ville);
    $sheet->getStyle('B15')->applyFromArray(['font' => ['size' => 9, 'color' => ['rgb' => $texte_gris]]]);

    $sheet->mergeCells('B16:F16');
    $sheet->setCellValue('B16', 'Email : ' . $email . '    |    Tél : +33 ' . $phone);
    $sheet->getStyle('B16')->applyFromArray(['font' => ['size' => 9, 'color' => ['rgb' => $texte_gris]]]);

    if (!empty($date_prestation)) {
        $sheet->mergeCells('B17:F17');
        $sheet->setCellValue('B17', 'Date souhaitée : ' . date('d/m/Y', strtotime($date_prestation)));
        $sheet->getStyle('B17')->applyFromArray(['font' => ['size' => 9, 'color' => ['rgb' => $texte_gris]]]);
    }

    // ── TABLEAU PRESTATIONS ───────────────────────────────────────────────────
    $sheet->getRowDimension('18')->setRowHeight(8);
    $sheet->getRowDimension('19')->setRowHeight(20);

    // En-têtes tableau
    $headers = ['B19' => 'DÉSIGNATION', 'C19' => 'DESCRIPTION', 'D19' => 'SURFACE (m²)', 'E19' => 'PU HT (€/m²)', 'F19' => 'MONTANT HT (€)'];
    foreach ($headers as $cell => $label) {
        $sheet->setCellValue($cell, $label);
    }
    $sheet->getStyle('B19:F19')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => $blanc]],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bleu_marine]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ]);

    // Ligne prestation
    $sheet->getRowDimension('20')->setRowHeight(30);
    $sheet->setCellValue('B20', $label_prestation);
    $sheet->setCellValue('C20', 'Nettoyage professionnel — ' . $ville);
    $sheet->setCellValue('D20', $surface);
    $sheet->setCellValue('E20', $prix_m2);
    $sheet->setCellValue('F20', $total_ht);

    $sheet->getStyle('B20:F20')->applyFromArray([
        'font'      => ['size' => 9],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bleu_clair]],
        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getStyle('D20:F20')->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'number_format' => ['format_code' => '#,##0.00'],
    ]);
    $sheet->getStyle('B20')->getAlignment()->setWrapText(true);
    $sheet->getStyle('C20')->getAlignment()->setWrapText(true);

    // Bordures tableau
    $sheet->getStyle('B19:F20')->applyFromArray([
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D1D5DB']],
            'outline'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => $bleu_marine]],
        ],
    ]);

    // ── TOTAUX ────────────────────────────────────────────────────────────────
    $sheet->getRowDimension('21')->setRowHeight(6);

    $totaux = [
        22 => ['label' => 'Total HT',         'value' => $total_ht,    'bold' => false, 'bg' => $gris_clair],
        23 => ['label' => 'TVA 10%',           'value' => $tva_montant, 'bold' => false, 'bg' => $gris_clair],
        24 => ['label' => 'TOTAL TTC',         'value' => $total_ttc,   'bold' => true,  'bg' => $bleu_marine, 'color' => $blanc],
    ];

    foreach ($totaux as $row => $t) {
        $sheet->getRowDimension((string)$row)->setRowHeight(18);
        $sheet->mergeCells("B{$row}:E{$row}");
        $sheet->setCellValue("B{$row}", $t['label']);
        $sheet->setCellValue("F{$row}", $t['value']);

        $txtColor = $t['color'] ?? $bleu_marine;
        $sheet->getStyle("B{$row}:F{$row}")->applyFromArray([
            'font'      => ['bold' => $t['bold'], 'size' => $t['bold'] ? 11 : 9, 'color' => ['rgb' => $txtColor]],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $t['bg']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle("B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B{$row}:F{$row}")->getBorders()->getOutline()
            ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('D1D5DB');
    }

    // ── NOTES ─────────────────────────────────────────────────────────────────
    if (!empty($notes)) {
        $sheet->getRowDimension('25')->setRowHeight(6);
        $sheet->getRowDimension('26')->setRowHeight(14);
        $sheet->getRowDimension('27')->setRowHeight(40);

        $sheet->mergeCells('B26:F26');
        $sheet->setCellValue('B26', 'INFORMATIONS COMPLÉMENTAIRES');
        $sheet->getStyle('B26')->applyFromArray([
            'font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => $bleu_marine]],
        ]);

        $sheet->mergeCells('B27:F27');
        $sheet->setCellValue('B27', $notes);
        $sheet->getStyle('B27')->applyFromArray([
            'font'      => ['size' => 9, 'italic' => true, 'color' => ['rgb' => $texte_gris]],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $gris_clair]],
            'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP],
        ]);
        $sheet->getStyle('B27:F27')->getBorders()->getOutline()
            ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('D1D5DB');
    }

    // ── FOOTER ────────────────────────────────────────────────────────────────
    $footerRow = !empty($notes) ? 29 : 26;
    $sheet->getRowDimension((string)$footerRow)->setRowHeight(6);
    $sheet->getRowDimension((string)($footerRow + 1))->setRowHeight(30);
    $sheet->mergeCells("A{$footerRow}:G{$footerRow}");
    $sheet->getStyle("A{$footerRow}:G{$footerRow}")->getFill()
        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bleu_marine);

    $fr = $footerRow + 1;
    $sheet->mergeCells("A{$fr}:G{$fr}");
    $sheet->setCellValue("B{$fr}",
        'TCP INTER SAS  |  7 rue Voltaire, 93000 Bobigny  |  contact@tcpinter.com  |  tcpinter.com  |  Tél : +33 06 44 07 28 80'
    );
    $sheet->getStyle("A{$fr}:G{$fr}")->applyFromArray([
        'font'      => ['size' => 8, 'color' => ['rgb' => $texte_gris]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $gris_clair]],
    ]);

    // Masquer le quadrillage
    $sheet->setShowGridlines(false);

    // ── EXPORT ────────────────────────────────────────────────────────────────
    $upload_dir = wp_upload_dir();
    $tmp_dir    = trailingslashit($upload_dir['basedir']) . 'tcp-proformas/';
    if (!is_dir($tmp_dir)) {
        wp_mkdir_p($tmp_dir);
        file_put_contents($tmp_dir . '.htaccess', 'Deny from all');
    }

    $filename = 'Proforma_' . $numero . '_' . sanitize_file_name($prenom . '_' . $nom) . '.xlsx';
    $filepath = $tmp_dir . $filename;

    $writer = new Xlsx($spreadsheet);
    $writer->save($filepath);

    return $filepath;
}
