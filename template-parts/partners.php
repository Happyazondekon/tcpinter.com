<?php
/**
 * Template Part: Partners Section
 */
$partners = tcp_get_partners();
// Filter out empty logos
$partners = array_filter($partners, fn($p) => !empty($p['logo']));
$partners = array_values($partners);
?>

<section class="partners" aria-label="Nos partenaires">
  <div class="container">
    <p class="partners-label label-lg text-muted">NOS PARTENAIRES</p>
  </div>
  <div class="partners-track" aria-hidden="true">
    <div class="partners-belt">
      <!-- First set -->
      <?php foreach ($partners as $p) : ?>
        <img src="<?php echo esc_url($p['logo']); ?>"
             alt="<?php echo esc_attr($p['name']); ?>"
             loading="lazy">
      <?php endforeach; ?>
      <!-- Duplicate for seamless loop -->
      <?php foreach ($partners as $p) : ?>
        <img src="<?php echo esc_url($p['logo']); ?>"
             alt="" role="presentation"
             loading="lazy">
      <?php endforeach; ?>
    </div>
  </div>
</section>
