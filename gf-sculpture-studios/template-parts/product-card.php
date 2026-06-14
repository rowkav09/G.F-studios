<?php
/**
 * Product card — used in "Latest from the Studio" section.
 *
 * @var WC_Product $args['product']  WooCommerce product object.
 */
if (!isset($args['product']) || !class_exists('WooCommerce')) return;

$product   = $args['product'];
$permalink = $product->get_permalink();
$title     = $product->get_name();
$price     = $product->get_price_html();
$thumb_id  = $product->get_image_id();
?>

<a href="<?php echo esc_url($permalink); ?>" class="product-card" aria-label="<?php echo esc_attr(sprintf(__('View %s', 'gf-sculpture'), $title)); ?>">

  <div class="product-card__image">
    <?php if ($thumb_id) : ?>
      <?php echo wp_get_attachment_image($thumb_id, 'product-card', false, [
        'loading' => 'lazy',
      ]); ?>
    <?php else : ?>
      <?php echo gfs_placeholder_img('', $title); ?>
    <?php endif; ?>
  </div>

  <h3 class="product-card__title"><?php echo esc_html($title); ?></h3>
  <div class="product-card__price"><?php echo wp_kses_post($price ?: __('Enquire', 'gf-sculpture')); ?></div>
  <span class="product-card__add"><?php esc_html_e('View Details', 'gf-sculpture'); ?></span>

</a>
