<?php
/**
 * Default page template
 */
get_header();
?>

<div class="section">
  <div class="container" style="max-width: 860px;">
    <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="headline-lg" style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
        <div class="entry-content body-md">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</div>

<?php get_footer(); ?>
