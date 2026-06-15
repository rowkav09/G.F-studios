<?php
/**
 * WooCommerce shop archive — woocommerce/archive-product.php
 * Fully custom — no WC default chrome.
 */
defined('ABSPATH') || exit;

get_template_part('template-parts/header');
?>

  <div class="container">

    <!-- Archive header -->
    <div class="archive-header">
      <span class="label section-label" data-reveal><?php esc_html_e('G.F. Sculpture Studios', 'gf-sculpture'); ?></span>
      <?php woocommerce_page_title(); // outputs <h1> ?>
      <p style="color:var(--mid-grey);font-size:0.875rem;margin-top:0.5rem;font-family:var(--font-sans);" data-reveal>
        <?php woocommerce_result_count(); ?>
      </p>
    </div>

    <!-- Filter strip -->
    <nav class="filter-bar" aria-label="<?php esc_attr_e('Filter by type', 'gf-sculpture'); ?>">
      <button class="filter-btn is-active" data-filter="all"><?php esc_html_e('All', 'gf-sculpture'); ?></button>
      <button class="filter-btn" data-filter="original"><?php esc_html_e('Original Works', 'gf-sculpture'); ?></button>
      <button class="filter-btn" data-filter="limited-edition"><?php esc_html_e('Limited Editions', 'gf-sculpture'); ?></button>
      <button class="filter-btn" data-filter="smaller"><?php esc_html_e('Smaller Works', 'gf-sculpture'); ?></button>
    </nav>

    <!-- Sort -->
    <div style="display:flex;justify-content:flex-end;margin-bottom:2rem;">
      <?php woocommerce_catalog_ordering(); ?>
    </div>

    <?php woocommerce_output_all_notices(); ?>

    <?php if (woocommerce_product_loop()) : ?>

    <?php do_action('woocommerce_before_shop_loop'); ?>

    <ul class="products" aria-label="<?php esc_attr_e('Shop products', 'gf-sculpture'); ?>">
      <?php
      while (have_posts()) {
        the_post();
        do_action('woocommerce_shop_loop');
        wc_get_template_part('content', 'product');
      }
      ?>
    </ul>

    <?php do_action('woocommerce_after_shop_loop'); ?>

    <?php else : ?>
      <?php do_action('woocommerce_no_products_found'); ?>
    <?php endif; ?>

  </div><!-- /.container -->

<?php get_template_part('template-parts/footer'); ?>
