<?php
/**
 * Template Part: CTA Banner
 */
$devis_url = esc_url(get_permalink(get_page_by_path('devis')));
?>

<section class="cta-banner" id="contact" aria-label="Appel à l'action">
  <div class="container">
    <h2>Prêt à transformer vos espaces ?</h2>
    <p>Rejoignez nos clients satisfaits et bénéficiez d'un environnement de travail sain et accueillant dès demain.</p>
    <a href="<?php echo $devis_url; ?>" class="btn btn-primary btn-lg">
      Obtenir mon devis gratuit
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
</section>
