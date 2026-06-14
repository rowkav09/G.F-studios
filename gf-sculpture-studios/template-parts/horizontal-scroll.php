<?php
/**
 * Horizontal scroll section — GSAP pinned cinematic moment.
 * Cards scroll horizontally as the user scrolls vertically.
 * On mobile (≤768px) this becomes a standard vertical stack.
 *
 * Cards are populated from the ACF 'hp_featured_works' relationship field.
 * Falls back to the 4 most recent artworks.
 */

$featured = gfs_field('hp_featured_works', get_the_ID(), []);

// Fallback: latest 4 artworks
if (empty($featured)) {
    $featured_query = gfs_get_artworks(['posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC']);
    $featured       = $featured_query->posts ?? [];
}

if (empty($featured)) return;
?>

<section class="h-scroll-section section" aria-label="<?php esc_attr_e('Featured Works', 'gf-sculpture'); ?>">
  <div class="h-scroll-track">

    <!-- Intro card -->
    <div class="h-scroll-intro">
      <span class="label h-scroll-intro__label" aria-hidden="true">
        <?php esc_html_e('Featured', 'gf-sculpture'); ?>
      </span>
      <h2 class="h-scroll-intro__heading section-heading">
        <?php esc_html_e('Works to Consider', 'gf-sculpture'); ?>
      </h2>
      <div class="h-scroll-progress" aria-hidden="true">
        <div class="h-scroll-progress__track">
          <div class="h-scroll-progress__bar"></div>
        </div>
        <span class="h-scroll-progress__label h-scroll-progress__label--scroll"><?php esc_html_e('Scroll', 'gf-sculpture'); ?></span>
      </div>
    </div>

    <?php foreach ($featured as $artwork) :
      $post_id   = is_object($artwork) ? $artwork->ID : (int) $artwork;
      $title     = get_the_title($post_id);
      $permalink = get_permalink($post_id);
      $thumb_id  = get_post_thumbnail_id($post_id);
      $material  = gfs_field('artwork_material',   $post_id, __('Sculpture', 'gf-sculpture'));
      $dims      = gfs_field('artwork_dimensions',  $post_id);

      // Price (if linked to a WC product)
      $price_html = '';
      if (class_exists('WooCommerce')) {
        $product = wc_get_product($post_id);
        if ($product) {
          $price_html = $product->get_price_html();
        }
      }

      $enquiry_only = gfs_field('artwork_enquiry_only', $post_id, false);
    ?>

    <article class="h-scroll-card" aria-label="<?php echo esc_attr($title); ?>">

      <!-- Image -->
      <div class="h-scroll-card__image">
        <?php if ($thumb_id) : ?>
          <?php echo wp_get_attachment_image($thumb_id, 'artwork-full', false, ['loading' => 'lazy']); ?>
        <?php else : ?>
          <?php echo gfs_placeholder_img('', $title); ?>
        <?php endif; ?>
      </div>

      <!-- Content overlay -->
      <div class="h-scroll-card__content">
        <h3 class="h-scroll-card__title">
          <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
        </h3>
        <p class="h-scroll-card__details">
          <?php echo esc_html($material); ?>
          <?php if ($dims) : ?>&nbsp;&middot;&nbsp;<?php echo esc_html($dims); ?><?php endif; ?>
        </p>
        <?php if ($price_html && !$enquiry_only) : ?>
          <span class="h-scroll-card__price"><?php echo wp_kses_post($price_html); ?></span>
        <?php elseif ($enquiry_only) : ?>
          <span class="h-scroll-card__price"><?php esc_html_e('Enquire', 'gf-sculpture'); ?></span>
        <?php endif; ?>
      </div>

    </article>

    <?php endforeach; ?>

  </div><!-- /.h-scroll-track -->
</section>
