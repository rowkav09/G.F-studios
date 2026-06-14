<?php
/**
 * Single artwork — single-artwork.php
 * Split layout: gallery left, sticky details right.
 */
get_template_part('template-parts/header');

the_post();
$post_id     = get_the_ID();
$title       = get_the_title();
$content     = get_the_content();
$thumb_id    = get_post_thumbnail_id();

// ACF fields
$material    = gfs_field('artwork_material',     $post_id, __('Sculpture', 'gf-sculpture'));
$year        = gfs_field('artwork_year',         $post_id);
$dimensions  = gfs_field('artwork_dimensions',   $post_id);
$edition     = gfs_field('artwork_edition',      $post_id);
$statement   = gfs_field('artwork_statement',    $post_id);
$images      = gfs_field('artwork_images',       $post_id, []);
$enquiry_only = gfs_field('artwork_enquiry_only', $post_id, false);
$avail       = gfs_field('artwork_availability', $post_id, 'available');

// WooCommerce price
$price_html   = '';
$wc_product   = class_exists('WooCommerce') ? wc_get_product($post_id) : null;
if ($wc_product) {
  $price_html = $wc_product->get_price_html();
}
?>

  <div class="container">
    <div class="single-artwork-layout">

      <!-- ── LEFT: GALLERY ─────────────── -->
      <div class="artwork-gallery">
        <!-- Primary image -->
        <div class="artwork-gallery__primary" role="button" tabindex="0" aria-label="<?php esc_attr_e('Enlarge image', 'gf-sculpture'); ?>">
          <?php if ($thumb_id) : ?>
            <?php echo wp_get_attachment_image($thumb_id, 'artwork-full', false, [
              'loading'          => 'eager',
              'fetchpriority'    => 'high',
            ]); ?>
          <?php else : ?>
            <?php echo gfs_placeholder_img('', $title); ?>
          <?php endif; ?>
        </div>

        <!-- Thumbnail strip -->
        <?php if (!empty($images)) : ?>
        <div class="artwork-gallery__thumbs" role="list" aria-label="<?php esc_attr_e('More views', 'gf-sculpture'); ?>">
          <!-- Primary thumb -->
          <?php if ($thumb_id) : ?>
          <button class="artwork-thumb is-active" role="listitem" aria-label="<?php esc_attr_e('Main view', 'gf-sculpture'); ?>">
            <?php echo wp_get_attachment_image($thumb_id, 'artwork-thumb', false, ['loading' => 'lazy']); ?>
          </button>
          <?php endif; ?>

          <?php foreach ($images as $image) :
            $img_url   = $image['sizes']['artwork-thumb'] ?? $image['url'];
            $full_url  = $image['sizes']['artwork-full']  ?? $image['url'];
            $alt       = $image['alt'] ?? $title;
          ?>
          <button class="artwork-thumb"
                  role="listitem"
                  aria-label="<?php echo esc_attr($alt); ?>"
                  data-full="<?php echo esc_url($full_url); ?>">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy">
          </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- ── RIGHT: STICKY DETAILS ─────── -->
      <aside class="artwork-details">
        <h1 class="artwork-details__title"><?php echo esc_html($title); ?></h1>
        <?php if ($year) : ?>
          <p class="artwork-details__year"><?php echo esc_html($year); ?></p>
        <?php endif; ?>

        <!-- Meta table -->
        <dl class="artwork-meta-table">
          <?php if ($material) : ?>
            <dt><?php esc_html_e('Material', 'gf-sculpture'); ?></dt>
            <dd><?php echo esc_html($material); ?></dd>
          <?php endif; ?>
          <?php if ($dimensions) : ?>
            <dt><?php esc_html_e('Dimensions', 'gf-sculpture'); ?></dt>
            <dd><?php echo esc_html($dimensions); ?></dd>
          <?php endif; ?>
          <?php if ($edition) : ?>
            <dt><?php esc_html_e('Edition', 'gf-sculpture'); ?></dt>
            <dd><?php echo esc_html($edition); ?></dd>
          <?php endif; ?>
          <?php if ($avail) : ?>
            <dt><?php esc_html_e('Status', 'gf-sculpture'); ?></dt>
            <dd>
              <span class="availability-badge availability-badge--<?php echo esc_attr($avail); ?>">
                <?php echo esc_html(ucfirst($avail)); ?>
              </span>
            </dd>
          <?php endif; ?>
        </dl>

        <!-- Price -->
        <?php if ($price_html && !$enquiry_only && $avail === 'available') : ?>
          <p class="artwork-price"><?php echo wp_kses_post($price_html); ?></p>
        <?php elseif ($avail === 'sold') : ?>
          <p class="artwork-price artwork-price--poa" style="color:var(--mid-grey);"><?php esc_html_e('Sold', 'gf-sculpture'); ?></p>
        <?php else : ?>
          <p class="artwork-price artwork-price--poa"><?php esc_html_e('Price on Application', 'gf-sculpture'); ?></p>
        <?php endif; ?>

        <!-- Artist statement for this piece -->
        <?php if ($statement) : ?>
        <div class="artwork-statement">
          <p><?php echo nl2br(esc_html($statement)); ?></p>
        </div>
        <?php elseif ($content) : ?>
        <div class="artwork-statement">
          <?php echo wp_kses_post(wpautop($content)); ?>
        </div>
        <?php endif; ?>

        <!-- CTA buttons -->
        <div class="artwork-actions">
          <?php if ($avail === 'available') :
            if ($enquiry_only) : ?>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) . '?subject=Enquiry+about+' . urlencode($title)); ?>"
                 class="btn btn--primary">
                <?php esc_html_e('Enquire About This Work', 'gf-sculpture'); ?>
              </a>
            <?php elseif ($wc_product) :
              // WooCommerce add to cart
              woocommerce_template_single_add_to_cart();
            else : ?>
              <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>"
                 class="btn btn--primary">
                <?php esc_html_e('Enquire About This Work', 'gf-sculpture'); ?>
              </a>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) . '?subject=Commission+enquiry'); ?>"
               class="btn btn--ghost">
              <?php esc_html_e('Commission a Similar Work', 'gf-sculpture'); ?>
            </a>
          <?php else : ?>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) . '?subject=Commission+enquiry'); ?>"
               class="btn btn--primary">
              <?php esc_html_e('Commission a Similar Work', 'gf-sculpture'); ?>
            </a>
          <?php endif; ?>
        </div>

      </aside>

    </div><!-- /.single-artwork-layout -->

    <!-- Lightbox -->
    <div class="lightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Image enlarged view', 'gf-sculpture'); ?>">
      <button class="lightbox__close" aria-label="<?php esc_attr_e('Close enlarged view', 'gf-sculpture'); ?>">
        <?php esc_html_e('Close', 'gf-sculpture'); ?>
      </button>
      <img class="lightbox__img" src="" alt="">
    </div>

    <!-- ── RELATED WORKS ──────────────── -->
    <?php
    $related_query = new WP_Query([
      'post_type'      => 'artwork',
      'posts_per_page' => 3,
      'post_status'    => 'publish',
      'post__not_in'   => [$post_id],
      'orderby'        => 'rand',
    ]);
    ?>
    <?php if ($related_query->have_posts()) : ?>
    <div class="related-works">
      <h2 class="section-heading" style="font-size:clamp(1.75rem,3vw,3rem);margin-bottom:2.5rem;" data-reveal>
        <?php esc_html_e('You May Also Like', 'gf-sculpture'); ?>
      </h2>
      <div class="artwork-grid">
        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
          <?php get_template_part('template-parts/artwork-card', null, ['post' => get_post()]); ?>
        <?php endwhile; ?>
      </div>
    </div>
    <?php wp_reset_postdata(); endif; ?>

  </div><!-- /.container -->

<?php get_template_part('template-parts/footer'); ?>
