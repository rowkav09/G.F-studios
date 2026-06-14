<?php
/**
 * WooCommerce cart — woocommerce/cart/cart.php
 * Styled to match theme. Loads WC's default cart hooks.
 */
defined('ABSPATH') || exit;

get_template_part('template-parts/header');
?>

  <div class="container">
    <div class="page-header">
      <span class="label section-label" data-reveal><?php esc_html_e('Your Selection', 'gf-sculpture'); ?></span>
      <h1 class="section-heading" data-reveal><?php esc_html_e('Shopping Cart', 'gf-sculpture'); ?></h1>
    </div>

    <?php do_action('woocommerce_before_cart'); ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
      <?php do_action('woocommerce_before_cart_table'); ?>

      <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
          <tr>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-name"><?php esc_html_e('Work', 'gf-sculpture'); ?></th>
            <th class="product-price"><?php esc_html_e('Price', 'gf-sculpture'); ?></th>
            <th class="product-quantity"><?php esc_html_e('Qty', 'gf-sculpture'); ?></th>
            <th class="product-subtotal"><?php esc_html_e('Total', 'gf-sculpture'); ?></th>
            <th class="product-remove">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php do_action('woocommerce_before_cart_contents'); ?>
          <?php
          foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) :
          ?>
          <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
            <td class="product-thumbnail">
              <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('artwork-thumb'), $cart_item, $cart_item_key); // phpcs:ignore ?>
            </td>
            <td class="product-name">
              <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url(get_permalink($product_id)), $product_name), $cart_item, $cart_item_key)); ?>
            </td>
            <td class="product-price">
              <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore ?>
            </td>
            <td class="product-quantity">
              <?php
              echo apply_filters( // phpcs:ignore
                'woocommerce_cart_item_quantity',
                woocommerce_quantity_input([
                  'input_name'   => "cart[{$cart_item_key}][qty]",
                  'input_value'  => $cart_item['quantity'],
                  'max_value'    => $_product->get_max_purchase_quantity(),
                  'min_value'    => '0',
                  'product_name' => $product_name,
                ], $_product, false),
                $cart_item_key,
                $cart_item
              );
              ?>
            </td>
            <td class="product-subtotal">
              <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore ?>
            </td>
            <td class="product-remove">
              <?php echo apply_filters( // phpcs:ignore
                'woocommerce_cart_item_remove_link',
                sprintf(
                  '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                  esc_url(wc_get_cart_remove_url($cart_item_key)),
                  esc_attr(sprintf(__('Remove %s from cart', 'gf-sculpture'), wp_strip_all_tags($product_name))),
                  esc_attr($product_id),
                  esc_attr($_product->get_sku())
                ),
                $cart_item_key
              ); ?>
            </td>
          </tr>
          <?php endif; } ?>
          <?php do_action('woocommerce_cart_contents'); ?>
        </tbody>
      </table>

      <?php do_action('woocommerce_cart_coupon'); ?>

      <div style="display:flex;justify-content:flex-end;margin-top:1.5rem;">
        <button type="submit" class="btn btn--ghost" name="update_cart" value="<?php esc_attr_e('Update Cart', 'gf-sculpture'); ?>">
          <?php esc_html_e('Update Cart', 'gf-sculpture'); ?>
        </button>
      </div>

      <?php do_action('woocommerce_after_cart_contents'); ?>
      <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>
    <div class="cart-collaterals">
      <?php do_action('woocommerce_cart_collaterals'); ?>
    </div>
    <?php do_action('woocommerce_after_cart'); ?>

  </div><!-- /.container -->

<?php get_template_part('template-parts/footer'); ?>
