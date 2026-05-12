</main><!-- #main-content -->

<!-- Floating CTA (mobile) -->
<a href="<?php echo esc_url(get_permalink(get_page_by_path('devis'))); ?>" class="fab-cta btn btn-primary" aria-label="Demander un devis gratuit">
  Devis gratuit
</a>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">

      <!-- Brand -->
      <div class="footer-brand">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_tcp_inter.png'); ?>"
             alt="TCP Inter" class="footer-logo" width="120" height="40">
        <p>Expert en hygiène et maintenance de vos locaux depuis 2022. Nous intervenons partout en Île-de-France avec précision et engagement.</p>
        <div class="footer-social">
          <a href="#" aria-label="Facebook" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="#" aria-label="Instagram" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
        </div>
      </div>

      <!-- Contact -->
      <div class="footer-col">
        <h4>Contact</h4>
        <div class="footer-contact-item">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <a href="https://maps.google.com/?q=TCP+INTER+7+rue+Voltaire+93000+Bobigny" target="_blank" rel="noopener noreferrer">7 rue Voltaire,<br>93000 Bobigny</a>
        </div>
        <div class="footer-contact-item">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 3h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 10.5a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+33644072880">+33 06 44 07 28 80</a>
        </div>
        <div class="footer-contact-item">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <a href="mailto:contact@tcpinter.com">contact@tcpinter.com</a>
        </div>
      </div>

      <!-- Liens rapides -->
      <div class="footer-col">
        <h4>Liens rapides</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/')); ?>#a-propos">À propos de nous</a></li>
          <li><a href="<?php echo esc_url(home_url('/')); ?>#services">Nos services</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('devis'))); ?>">Demande de devis</a></li>
          <li><a href="<?php echo esc_url(home_url('/')); ?>#faq">FAQ</a></li>
          <li><a href="<?php echo esc_url(home_url('/')); ?>#contact">Contact</a></li>
        </ul>
      </div>

      <!-- Mentions légales -->
      <div class="footer-col">
        <h4>Mentions légales</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>">Politique de confidentialité</a></li>
          <li><a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions légales</a></li>
          <li><a href="javascript:void(0)" aria-disabled="true">CGV</a></li>
        </ul>
      </div>

    </div><!-- .footer-grid -->

    <div class="footer-bottom">
      <p>© <?php echo date('Y'); ?> TCP Inter Cleaning Services. Tous droits réservés.</p>
      <div class="footer-bottom-links">
        <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions légales</a>
        <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>">Confidentialité</a>
        <a href="javascript:void(0)" aria-disabled="true">CGV</a>
      </div>
    </div>

  </div>
</footer>

<?php wp_footer(); ?>

<!-- Cookie Consent Banner -->
<div id="tcp-cookie-banner" role="dialog" aria-live="polite" aria-label="Gestion des cookies">
  <span class="cookie-banner-icon">🍪</span>
  <p class="cookie-banner-title">Ce site utilise des cookies</p>
  <p class="cookie-banner-text">
    Uniquement des cookies techniques nécessaires au bon fonctionnement du site. Aucun cookie publicitaire ni de traçage.
    <a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>">En savoir plus</a>
  </p>
  <div class="cookie-banner-actions">
    <button id="cookie-accept">Accepter</button>
    <button id="cookie-refuse">Refuser</button>
  </div>
</div>

</body>
</html>
