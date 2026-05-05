<?php
/**
 * Fallback menu when no menu is set
 */
function tcp_fallback_menu(): void {
    $base = esc_url(home_url('/'));
    echo '
    <a href="' . $base . '">Accueil</a>
    <a href="' . $base . '#a-propos">À propos</a>
    <div class="menu-item-has-children">
      <a href="' . $base . '#services">Services</a>
      <ul class="sub-menu">
        <li><a href="' . esc_url(home_url('/services/nettoyage-bureaux/')) . '">Nettoyage de bureaux</a></li>
        <li><a href="' . esc_url(home_url('/services/fin-de-chantier/')) . '">Fin de chantier</a></li>
        <li><a href="' . esc_url(home_url('/services/nettoyage-domicile/')) . '">Nettoyage à domicile</a></li>
      </ul>
    </div>
    <a href="' . $base . '#faq">FAQ</a>
    <a href="' . $base . '#contact">Contact</a>
    ';
}
