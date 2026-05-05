<?php
/**
 * Template Part: Map Section (Île-de-France)
 */
$cities = tcp_get_cities();
$devis_url = esc_url(get_permalink(get_page_by_path('devis')));
?>

<section class="section map-section section-alt" id="zones" aria-labelledby="map-heading">
  <div class="container">
    <div class="map-grid">

      <!-- Info side -->
      <div class="map-info">
        <span class="label-lg section-label text-secondary">Zones d'intervention</span>
        <h2 class="headline-lg" id="map-heading">Partout en Île-de-France</h2>
        <p class="body-md">Nous intervenons rapidement sur toute la région parisienne. Que vous soyez à Paris ou en banlieue, nos équipes sont mobiles, réactives et toujours ponctuelles.</p>

        <div class="cities-list" role="list">
          <?php foreach ($cities as $city) : ?>
            <div class="city-item" role="listitem">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <?php echo esc_html($city); ?>
            </div>
          <?php endforeach; ?>
        </div>

      </div>

      <!-- Map side -->
      <div class="map-container" aria-label="Carte des zones d'intervention en Île-de-France">
        <div id="tcp-map" role="img" aria-label="Carte Île-de-France avec épingles des villes TCP Inter"></div>
      </div>

    </div>
  </div>
</section>
