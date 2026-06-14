<?php
/**
 * Statement piece section — full-bleed, image left / text right.
 * Controlled via ACF homepage options or passed $args.
 */
$heading  = gfs_field('hp_statement_heading', get_the_ID(), __('Statement Works', 'gf-sculpture'));
$text     = gfs_field('hp_statement_text',    get_the_ID(), '[PLACEHOLDER: Short paragraph about Geoff\'s approach to large-scale and statement works — the ambition, the materials, the process.]');
$shop_url = class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : get_post_type_archive_link('artwork');
?>

<section class="statement-piece section" aria-label="<?php esc_attr_e('Statement Works', 'gf-sculpture'); ?>">

  <!-- Image — left side, parallax applied by animations.js -->
  <div class="statement-piece__image parallax-img" aria-hidden="true">
    <!-- [PLACEHOLDER: Replace with an ACF image or featured sculpture photo] -->
    <?php echo gfs_placeholder_img('', 'Statement sculpture by Geoff Fahey'); ?>
  </div>

  <!-- Content — right side -->
  <div class="statement-piece__content">
    <span class="label section-label" data-reveal>
      <?php esc_html_e('Selected Works', 'gf-sculpture'); ?>
    </span>
    <h2 class="section-heading statement-piece__heading" data-reveal>
      <?php echo esc_html($heading); ?>
    </h2>
    <p class="statement-piece__text" data-reveal>
      <?php echo wp_kses_post($text); ?>
    </p>
    <div data-reveal>
      <a href="<?php echo esc_url($shop_url); ?>" class="btn btn--primary">
        <?php esc_html_e('Explore the Collection', 'gf-sculpture'); ?>
      </a>
    </div>
  </div>

</section>
