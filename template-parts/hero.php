<?php
/**
 * Template Part: Hero Section
 */
$hero_img = get_template_directory_uri() . '/assets/images/hero.png';
$hero_vid = get_template_directory_uri() . '/assets/images/hero_video.mp4';
$devis_url = esc_url(get_permalink(get_page_by_path('devis')));
$services_url = esc_url(home_url('/')) . '#services';
?>

<section class="hero" aria-label="Bannière principale">

  <!-- Background: video with image fallback -->
  <div class="hero-bg" aria-hidden="true">
    <video autoplay muted loop playsinline preload="none"
           poster="<?php echo esc_url($hero_img); ?>">
      <source src="<?php echo esc_url($hero_vid); ?>" type="video/mp4">
    </video>
  </div>

  <div class="container">
    <div class="hero-content">

      <h1>Un espace propre,<br><span>une image impeccable</span></h1>

      <p class="hero-description">
        TCP Inter assure l'hygiène et la maintenance de vos locaux avec une précision industrielle et un service client sur-mesure.
      </p>

      <div class="hero-actions">
        <a href="<?php echo $devis_url; ?>" class="btn btn-primary btn-lg">
          Demandez un devis gratuit
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="<?php echo $services_url; ?>" class="btn btn-outline btn-lg" data-scroll="true">
          Découvrir nos services
        </a>
      </div>

    </div><!-- .hero-content -->

  </div><!-- .container -->
</section>
