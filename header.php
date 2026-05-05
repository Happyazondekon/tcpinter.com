<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/favicon.ico">
  <?php if (is_front_page()) : ?>
  <link rel="preload" as="image" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero.png" fetchpriority="high">
  <?php endif; ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main-content">Aller au contenu principal</a>

<header class="site-header" role="banner">
  <div class="container">
    <div class="header-inner">

      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?> – Accueil">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            $logo = get_template_directory_uri() . '/assets/images/logo_tcp_inter.png';
            echo '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" width="120" height="44">';
        }
        ?>
      </a>

      <!-- Navigation -->
      <nav class="primary-nav" role="navigation" aria-label="Menu principal" id="primary-nav">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => '',
            'container'      => false,
            'fallback_cb'    => 'tcp_fallback_menu',
            'items_wrap'     => '%3$s',
        ]);
        ?>
      </nav>

      <!-- CTA button -->
      <div class="header-cta">
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('devis'))); ?>" class="btn btn-primary btn-sm">
          Devis gratuit
        </a>
      </div>

      <!-- Mobile toggle -->
      <button class="menu-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Ouvrir le menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

    </div>
  </div>
</header>

<main id="main-content">
