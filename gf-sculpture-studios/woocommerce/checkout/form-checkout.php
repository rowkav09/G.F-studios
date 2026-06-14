<?php
/**
 * WooCommerce checkout form — woocommerce/checkout/form-checkout.php
 */
defined('ABSPATH') || exit;

if (!is_checkout()) return;

get_template_part('template-parts/header');
?>

  <div class="container">
    <div class="page-header">
      <span class="label section-label" data-reveal><?php esc_html_e('Almost there', 'gf-sculpture'); ?></span>
      <h1 class="section-heading" data-reveal><?php esc_html_e('Checkout', 'gf-sculpture'); ?></h1>
    </div>

    <?php woocommerce_output_all_notices(); ?>

    <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout"
          action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

      <?php if ($checkout->get_checkout_fields()) : ?>
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>
        <div class="col2-set" id="customer_details">
          <div class="col-1">
            <?php do_action('woocommerce_checkout_billing'); ?>
          </div>
          <div class="col-2">
            <?php do_action('woocommerce_checkout_shipping'); ?>
          </div>
        </div>
        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
      <?php endif; ?>

      <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
      <h3 id="order_review_heading"><?php esc_html_e('Your order', 'gf-sculpture'); ?></h3>
      <?php do_action('woocommerce_checkout_before_order_review'); ?>
      <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action('woocommerce_checkout_order_review'); ?>
      </div>
      <?php do_action('woocommerce_checkout_after_order_review'); ?>

    </form>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
  </div>

<?php get_template_part('template-parts/footer'); ?>
