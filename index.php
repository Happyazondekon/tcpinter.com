<?php
/**
 * index.php - WordPress fallback template
 */
get_header();
?>

<div class="section">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="grid-3">
        <?php while (have_posts()) : the_post(); ?>
          <article class="card" style="padding: 1.5rem;">
            <h2 style="margin-bottom: 0.5rem; font-size: 1.125rem;">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="body-sm text-muted"><?php the_excerpt(); ?></p>
          </article>
        <?php endwhile; ?>
      </div>
    <?php else : ?>
      <p class="text-center">Aucun article trouvé.</p>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
