<?php
/**
 * Template Name: Page Devis
 * Description: Page formulaire de devis
 */
get_header();
?>

<div class="devis-page">
  <div class="container">

    <div class="devis-header">
      <h1>Obtenez votre devis gratuit</h1>
      <p>Confiez-nous l'entretien de vos locaux. Complétez le formulaire ci-dessous et recevez une proposition personnalisée sous 24h.</p>
    </div>

    <div class="devis-form-wrap">

      <div id="form-message" class="form-message" role="alert" aria-live="polite"></div>

      <form id="devis-form" novalidate enctype="multipart/form-data" aria-label="Formulaire de demande de devis">

        <!-- Row 1: Ville + Date -->
        <div class="form-row">
          <div class="form-group">
            <label for="ville">La ville où va être réalisé la prestation <span class="required" aria-hidden="true">*</span></label>
            <select id="ville" name="ville" required aria-required="true">
              <option value="">Sélectionnez une ville</option>
              <?php
              $cities = tcp_get_cities();
              foreach ($cities as $city) {
                  echo '<option value="' . esc_attr($city) . '">' . esc_html($city) . '</option>';
              }
              ?>
              <option value="autre">Autre ville (précisez dans les notes)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="date">Date souhaitée de la prestation</label>
            <input type="date" id="date" name="date"
                   min="<?php echo esc_attr(date('Y-m-d', strtotime('+1 day'))); ?>"
                   aria-label="Date souhaitée de la prestation">
          </div>
        </div>

        <!-- Row 2: Type de prestation + Surface -->
        <div class="form-row">
          <div class="form-group">
            <label for="type_prestation">Type de prestation <span class="required" aria-hidden="true">*</span></label>
            <select id="type_prestation" name="type_prestation" required aria-required="true">
              <option value="">Sélectionnez un type</option>
              <option value="bureaux" data-prix="1.10">Bureaux / Locaux tertiaires — 1,10 €/m²</option>
              <option value="parties_communes" data-prix="0.75">Parties communes (copropriété) — 0,75 €/m²</option>
              <option value="commerces" data-prix="1.20">Commerces / Boutiques — 1,20 €/m²</option>
              <option value="entrepots" data-prix="0.60">Entrepôts / Industriel — 0,60 €/m²</option>
              <option value="apres_chantier" data-prix="5.50">Après chantier (remise en état) — 5,50 €/m²</option>
              <option value="vitrerie" data-prix="9.00">Vitrerie (intérieur + extérieur) — 9,00 €/m²</option>
              <option value="desinfection" data-prix="3.50">Désinfection / Traitement — 3,50 €/m²</option>
            </select>
          </div>
          <div class="form-group">
            <label for="surface">Surface à nettoyer (m²) <span class="required" aria-hidden="true">*</span></label>
            <input type="number" id="surface" name="surface" min="1" max="100000"
                   placeholder="Ex : 250"
                   required aria-required="true">
          </div>
        </div>

        <!-- Estimation de prix -->
        <div id="devis-estimation" class="devis-estimation" style="display:none;" aria-live="polite">
          <div class="devis-estimation-inner">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <div>
              <span class="estimation-label">Estimation indicative :</span>
              <strong id="estimation-value" class="estimation-value">—</strong>
              <span class="estimation-note">HT / intervention · Prix ferme sur devis définitif</span>
            </div>
          </div>
        </div>

        <!-- File upload -->
        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label for="file-media">Photos ou vidéo de l'endroit</label>
          <div class="file-upload" id="file-drop-zone" onclick="document.getElementById('file-media').click()">
            <input type="file" id="file-media" name="media[]" multiple
                   accept="image/jpeg,image/png,video/mp4"
                   aria-label="Choisir des fichiers photos ou vidéo">
            <div class="file-upload-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <polyline points="16 16 12 12 8 16"/>
                <line x1="12" y1="12" x2="12" y2="21"/>
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
              </svg>
            </div>
            <div class="file-upload-text">
              <strong id="file-label-text">Glissez et déposez (ou) Choisissez des fichiers</strong>
              <span>Formats acceptés : JPG, PNG, MP4 (Max 20Mo)</span>
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div class="form-group" style="margin-bottom: 1.75rem;">
          <label for="notes">Avez-vous des informations complémentaires à préciser</label>
          <textarea id="notes" name="notes" rows="4"
                    placeholder="Ex: Fréquence souhaitée, spécificités des sols, accès particulier…"></textarea>
        </div>

        <!-- Coordonnées heading -->
        <p class="form-section-title">Vos coordonnées</p>

        <!-- Row: Prénom + Nom -->
        <div class="form-row">
          <div class="form-group">
            <label for="prenom">Prénom <span class="required" aria-hidden="true">*</span></label>
            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom"
                   required aria-required="true" autocomplete="given-name">
          </div>
          <div class="form-group">
            <label for="nom">Nom de famille <span class="required" aria-hidden="true">*</span></label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom"
                   required aria-required="true" autocomplete="family-name">
          </div>
        </div>

        <!-- Row: Téléphone + Email -->
        <div class="form-row" style="margin-bottom: 1.5rem;">
          <div class="form-group">
            <label for="phone">Téléphone <span class="required" aria-hidden="true">*</span></label>
            <div class="phone-input-group">
              <span class="phone-prefix" aria-label="Indicatif France">+33</span>
              <input type="tel" id="phone" name="phone"
                     placeholder="06 12 34 56 78"
                     required aria-required="true"
                     autocomplete="tel-national"
                     maxlength="14">
            </div>
          </div>
          <div class="form-group">
            <label for="email">Adresse e-mail <span class="required" aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" placeholder="contact@entreprise.com"
                   required aria-required="true" autocomplete="email">
          </div>
        </div>

        <!-- Privacy -->
        <div class="form-privacy">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          Uniquement dans le cadre de votre demande de devis, nous n'envoyons pas d'email indésirable.
        </div>

        <!-- Submit -->
        <div class="form-submit">
          <button type="submit" class="btn btn-primary btn-lg">
            Envoyer ma demande de devis
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          </button>
        </div>

      </form>
    </div><!-- .devis-form-wrap -->

  </div><!-- .container -->
</div><!-- .devis-page -->

<?php get_footer(); ?>
