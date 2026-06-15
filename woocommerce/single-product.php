<?php
/**
 * WooCommerce single product — woocommerce/single-product.php
 */
defined('ABSPATH') || exit;

get_template_part('template-parts/header');

while (have_posts()) {
  the_post();
  wc_get_template_part('content', 'single-product');
}
?>

<?php get_template_part('template-parts/footer'); ?>
