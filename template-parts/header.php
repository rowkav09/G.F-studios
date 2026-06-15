<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#FFFFFF">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Page Load Curtain -->
<div class="page-curtain" aria-hidden="true"></div>

<!-- Site Header -->
<header class="site-header<?php echo is_front_page() ? ' site-header--dark' : ''; ?>" role="banner">

  <!-- Logo -->
  <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?> — Home">
    <?php
    $logo = get_theme_mod('custom_logo');
    if ($logo) {
      echo wp_get_attachment_image($logo, 'full');
    } else {
      // Inline SVG placeholder
      $logo_path = get_template_directory() . '/assets/images/logo.svg';
      if (file_exists($logo_path)) {
        echo file_get_contents($logo_path); // phpcs:ignore WordPress.Security.EscapeOutput
      } else {
        echo '<span style="font-family:\'Cormorant Garamond\',serif;font-weight:300;font-size:1.1rem;letter-spacing:0.05em;">' . esc_html(get_bloginfo('name')) . '</span>';
      }
    }
    ?>
  </a>

  <!-- Desktop nav + cart -->
  <nav class="site-nav" role="navigation" aria-label="<?php esc_attr_e('Primary navigation', 'gf-sculpture'); ?>">
    <ul class="site-nav__links" role="list">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '%3$s',
        'walker'         => new GFS_Nav_Walker(),
        'fallback_cb'    => function () {
          // Fallback manual links
          $links = [
            'Portfolio' => get_post_type_archive_link('artwork'),
            'Shop'      => get_permalink(wc_get_page_id('shop')),
            'About'     => get_permalink(get_page_by_path('about')),
            'Contact'   => get_permalink(get_page_by_path('contact')),
          ];
          foreach ($links as $label => $url) {
            if ($url) {
              printf(
                '<li class="nav-item"><a href="%s" class="nav-link">%s</a></li>',
                esc_url($url),
                esc_html($label)
              );
            }
          }
        },
      ]);
      ?>
    </ul>

    <?php if (class_exists('WooCommerce')) : ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-icon" aria-label="<?php esc_attr_e('Shopping cart', 'gf-sculpture'); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
      </svg>
      <?php
      $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
      if ($count > 0) {
        printf('<span class="cart-count" aria-label="%s items in cart">%d</span>', $count, $count);
      }
      ?>
    </a>
    <?php endif; ?>

    <!-- Hamburger (mobile) -->
    <button class="hamburger" aria-expanded="false" aria-label="<?php esc_attr_e('Open menu', 'gf-sculpture'); ?>" aria-controls="nav-overlay">
      <span class="hamburger-line" aria-hidden="true"></span>
      <span class="hamburger-line" aria-hidden="true"></span>
      <span class="hamburger-line" aria-hidden="true"></span>
    </button>
  </nav>

</header>

<!-- Mobile Nav Overlay -->
<div class="nav-overlay" id="nav-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Navigation menu', 'gf-sculpture'); ?>">
  <div class="nav-overlay__content">
    <nav aria-label="<?php esc_attr_e('Mobile navigation', 'gf-sculpture'); ?>">
      <ul class="nav-overlay__links" role="list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-overlay__link">Home</a></li>
        <li><a href="<?php echo esc_url(get_post_type_archive_link('artwork')); ?>" class="nav-overlay__link">Portfolio</a></li>
        <?php if (class_exists('WooCommerce')) : ?>
        <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="nav-overlay__link">Shop</a></li>
        <?php endif; ?>
        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="nav-overlay__link">About</a></li>
        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="nav-overlay__link">Contact</a></li>
      </ul>
    </nav>
    <div class="nav-overlay__footer">
      <!-- [PLACEHOLDER: Add social links] -->
      <a href="#" aria-label="Instagram">Instagram</a>
      <a href="#" aria-label="Facebook">Facebook</a>
    </div>
  </div>
  <!-- Right side: atmospheric sculpture image -->
  <div class="nav-overlay__image" aria-hidden="true">
    <?php echo gfs_placeholder_img('', 'Studio atmosphere'); ?>
  </div>
</div>

<main id="main" class="site-main">
