<?php
/**
 * Template Part: About Section
 */
$about_img = get_template_directory_uri() . '/assets/images/about_one.png';
$dg_img    = get_template_directory_uri() . '/assets/images/dg_tcpinter.png';
?>

<section class="section about-section" id="a-propos" aria-labelledby="about-heading">
  <div class="container">
    <div class="about-grid">

      <!-- Text side -->
      <div class="about-content">
        <span class="label-lg section-label text-secondary">À propos de TCP Inter</span>
        <h2 class="headline-lg" id="about-heading">
          Engagement et excellence pour votre environnement
        </h2>
        <p class="about-text body-lg">
          Depuis 4 ans, TCP Inter s'impose comme un acteur majeur de la propreté en Île-de-France. Notre approche repose sur la formation continue de nos agents et l'utilisation de produits professionnels certifiés.
        </p>
        <p class="about-text body-md" style="margin-bottom: 1.5rem; color: var(--color-on-surface-var);">
          Nous nous concentrons pas de nettoyer : nous préservons votre patrimoine immobilier et contribuons au bien-être de vos collaborateurs et de vos proches.
        </p>

        <div class="about-badges">
          <span class="badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Certifié normes qualité
          </span>
          <span class="badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M2 22L16 8M16 2s4 4 4 8-4 4-4 4H8S4 14 8 10s8-8 8-8z"/></svg>
            Éco-responsable
          </span>
          <span class="badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Disponible 6j/7
          </span>
        </div>

        <a href="<?php echo esc_url(home_url('/')); ?>#contact" class="btn btn-outline-dark">
          En savoir plus sur nous
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>

      <!-- Image side -->
      <div class="about-image">
        <img src="<?php echo esc_url($about_img); ?>"
             alt="L'équipe TCP Inter en action, tenue professionnelle"
             width="600" height="480"
             loading="lazy">
      </div>

    </div>

    <!-- Mot du Directeur -->
    <div class="dg-block">
      <div class="dg-photo-wrap">
        <img src="<?php echo esc_url($dg_img); ?>"
             alt="Directeur Général de TCP Inter"
             class="dg-photo"
             width="240" height="280"
             loading="lazy">
      </div>
      <div class="dg-content">
        <span class="label-lg section-label text-secondary">Mot du Président</span>
        <svg class="dg-quote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 40" aria-hidden="true">
          <path d="M0 40V24.667C0 18.556 1.333 13.333 4 9 6.667 4.556 11.111 1.556 17.333 0L20 4.667C16.444 5.778 13.778 7.667 12 10.333 10.222 13 9.333 16 9.333 19.333H18V40H0zm28 0V24.667c0-6.111 1.333-11.334 4-15.667C34.667 4.556 39.111 1.556 45.333 0L48 4.667c-3.556 1.111-6.222 3-8 5.666C38.222 13 37.333 16 37.333 19.333H46V40H28z" fill="currentColor"/>
        </svg>
        <blockquote class="dg-message">
          <p>Chez TCP Inter, chaque intervention est une promesse tenue. Depuis la création de notre entreprise, j'ai voulu bâtir une structure où la rigueur professionnelle et le respect du client ne sont pas des options, mais des fondations.</p>
          <p>Nous ne faisons pas que nettoyer des espaces, nous créons des environnements sains, sécurisés et agréables dans lesquels vos équipes peuvent s'épanouir et vos activités prospérer.</p>
          <p>C'est cette conviction qui guide chacun de nos agents, chaque jour, sur le terrain.</p>
        </blockquote>
        <div class="dg-identity">
          <strong class="dg-name">M. Théophile Nounahon</strong>
          <span class="dg-title">Président TCP INTER SAS</span>
        </div>
      </div>
    </div>

  </div>
</section>
