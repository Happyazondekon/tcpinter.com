<?php
/**
 * Template Part: Testimonials Section
 */
$testimonials = tcp_get_testimonials();
?>

<section class="section" id="temoignages" aria-labelledby="testimonials-heading">
  <div class="container">

    <div class="section-header">
      <span class="label-lg section-label text-secondary">Témoignages clients</span>
      <h2 class="headline-lg" id="testimonials-heading">Ce que disent nos clients</h2>
      <p class="body-md text-muted">La satisfaction de nos partenaires est notre plus belle récompense. Voici ce qu'ils disent de nous.</p>
    </div>

    <!-- Carousel wrapper -->
    <div class="testimonials-carousel" aria-label="Carousel de témoignages">

      <div class="testimonials-track" id="testimonials-track">
        <?php foreach ($testimonials as $i => $t) : ?>
          <article class="testimonial-card" aria-label="Témoignage <?php echo $i + 1; ?>">

            <!-- Stars -->
            <div class="stars" aria-label="<?php echo esc_attr($t['rating']); ?> étoiles sur 5">
              <?php for ($s = 0; $s < 5; $s++) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                     style="<?php echo $s < $t['rating'] ? '' : 'opacity:0.3;'; ?>">
                  <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
              <?php endfor; ?>
            </div>

            <blockquote class="testimonial-text">
              <?php echo wp_kses_post($t['text']); ?>
            </blockquote>

            <footer class="testimonial-author">
              <div class="author-avatar" aria-hidden="true">
                <?php if (!empty($t['avatar'])) : ?>
                  <img src="<?php echo esc_url($t['avatar']); ?>" alt="<?php echo esc_attr($t['name']); ?>" width="44" height="44" loading="lazy">
                <?php else : ?>
                  <?php echo esc_html($t['initial']); ?>
                <?php endif; ?>
              </div>
              <div>
                <div class="author-name"><?php echo esc_html($t['name']); ?></div>
                <?php if (!empty($t['role'])) : ?>
                  <div class="author-role"><?php echo esc_html($t['role']); ?></div>
                <?php endif; ?>
              </div>
            </footer>

          </article>
        <?php endforeach; ?>
      </div>

      <!-- Navigation -->
      <div class="carousel-nav" aria-label="Navigation du carousel">
        <button class="carousel-btn carousel-prev" id="tc-prev" aria-label="Avis précédent">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="carousel-dots" id="tc-dots" aria-live="polite">
          <?php foreach ($testimonials as $i => $t) : ?>
            <button class="carousel-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo $i; ?>" aria-label="Avis <?php echo $i + 1; ?>"></button>
          <?php endforeach; ?>
        </div>
        <button class="carousel-btn carousel-next" id="tc-next" aria-label="Avis suivant">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
        </button>
      </div>

    </div>

  </div>
</section>
