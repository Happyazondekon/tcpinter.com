<?php
/**
 * Template Part: Solutions & Services Section
 */
$img_entreprise   = get_template_directory_uri() . '/assets/images/entreprise.png';
$img_particuliers = get_template_directory_uri() . '/assets/images/Particuliers.png';
$icon_bureau      = get_template_directory_uri() . '/assets/images/icon_bureau.png';
$icon_chantier    = get_template_directory_uri() . '/assets/images/icone_chantier.png';
$icon_domicile    = get_template_directory_uri() . '/assets/images/icone_domicile.png';
$devis_url = esc_url(get_permalink(get_page_by_path('devis')));
?>

<section class="section section-alt" id="services" aria-labelledby="solutions-heading">
  <div class="container">

    <div class="section-header">
      <span class="label-lg section-label text-secondary">Nos solutions</span>
      <h2 class="headline-lg" id="solutions-heading">Des solutions adaptées à chaque besoin</h2>
      <p class="body-md text-muted">Que vous soyez un gestionnaire de parc immobilier ou un particulier exigeant, nous avons la prestation de nettoyage qu'il vous faut.</p>
    </div>

    <!-- Big solution cards -->
    <div class="solutions-intro">

      <!-- PRO -->
      <div class="solution-wrap">
        <div class="solution-card" role="article">
          <img src="<?php echo esc_url($img_entreprise); ?>"
               alt="Nettoyage professionnel pour entreprises" loading="lazy">
          <div class="solution-card-overlay">
            <h3>Vous êtes une entreprise ?</h3>
            <p>Entretien courant de vos bureaux, remise en état après travaux, maintenance de copropriétés et sites industriels.</p>
            <button class="solution-toggle" aria-expanded="false" aria-controls="expand-pro">
              Voir les solutions Pro
              <svg class="toggle-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            </button>
          </div>
        </div>
        <div class="solution-expand" id="expand-pro" hidden>
          <div class="solution-expand-inner">
            <div class="solution-expand-service">
              <h4>
                <img src="<?php echo esc_url($icon_bureau); ?>" width="24" height="24" alt="" aria-hidden="true" loading="lazy">
                Nettoyage de bureaux
              </h4>
              <ul>
                <li>Dépoussiérage, aspiration et nettoyage des sols</li>
                <li>Désinfection des sanitaires et espaces communs</li>
                <li>Nettoyage des vitres intérieures</li>
                <li>Intervention matin ou soir selon votre activité</li>
              </ul>
            </div>
            <div class="solution-expand-service">
              <h4>
                <img src="<?php echo esc_url($icon_chantier); ?>" width="24" height="24" alt="" aria-hidden="true" loading="lazy">
                Nettoyage fin de chantier
              </h4>
              <ul>
                <li>Évacuation des déchets et gravats résiduels</li>
                <li>Nettoyage complet des surfaces et menuiseries</li>
                <li>Dégraissage des équipements et appareils</li>
                <li>Livraison de locaux prêts à l'usage</li>
              </ul>
            </div>
            <a href="<?php echo $devis_url; ?>" class="btn btn-primary btn-sm solution-expand-cta">
              Demander un devis gratuit
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>

      <!-- PARTICULIER -->
      <div class="solution-wrap">
        <div class="solution-card" role="article">
          <img src="<?php echo esc_url($img_particuliers); ?>"
               alt="Nettoyage à domicile pour particuliers" loading="lazy">
          <div class="solution-card-overlay">
            <h3>Vous êtes un particulier ?</h3>
            <p>Ménage régulier, grand nettoyage ponctuel, entretien de votre résidence principale ou secondaire, discret et efficace.</p>
            <button class="solution-toggle" aria-expanded="false" aria-controls="expand-part">
              Voir les solutions Particulières
              <svg class="toggle-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            </button>
          </div>
        </div>
        <div class="solution-expand" id="expand-part" hidden>
          <div class="solution-expand-inner">
            <div class="solution-expand-service">
              <h4>
                <img src="<?php echo esc_url($icon_domicile); ?>" width="24" height="24" alt="" aria-hidden="true" loading="lazy">
                Nettoyage à domicile
              </h4>
              <ul>
                <li>Ménage régulier ou grand nettoyage ponctuel</li>
                <li>Cuisine, salle de bain, sols et vitres</li>
                <li>Entretien du linge en option</li>
                <li>Discrétion et respect de votre intérieur</li>
              </ul>
            </div>
            <a href="<?php echo $devis_url; ?>" class="btn btn-primary btn-sm solution-expand-cta">
              Demander un devis gratuit
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
