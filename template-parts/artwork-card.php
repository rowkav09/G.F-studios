<?php
/**
 * Artwork card — used in grids across the site.
 *
 * @var WP_Post $args['post']     The artwork post object.
 * @var bool    $args['show_meta'] Show title/material/year below card (default true).
 * @var bool    $args['link']      Wrap card in anchor (default true).
 */
if (!isset($args['post'])) return;

$post        = $args['post'];
$show_meta   = isset($args['show_meta']) ? $args['show_meta'] : true;
$link        = isset($args['link']) ? $args['link'] : true;

$post_id     = $post->ID;
$permalink   = get_permalink($post_id);
$title       = get_the_title($post_id);
$thumb_id    = get_post_thumbnail_id($post_id);
$material    = gfs_field('artwork_material', $post_id, __('Sculpture', 'gf-sculpture'));
$year        = gfs_field('artwork_year', $post_id);
$avail       = gfs_field('artwork_availability', $post_id, 'available');

// Data attribute for JS filter
$mat_slug = sanitize_html_class(strtolower($material));
?>

<<?php echo $link ? 'a href="' . esc_url($permalink) . '"' : 'div'; ?>
  class="artwork-card"
  data-material="<?php echo esc_attr($mat_slug); ?>"
  data-filter="<?php echo esc_attr($mat_slug); ?>"
  <?php echo $link ? 'aria-label="' . esc_attr(sprintf(__('View artwork: %s', 'gf-sculpture'), $title)) . '"' : ''; ?>
>

  <!-- Image -->
  <div class="artwork-card__image">
    <?php if ($thumb_id) : ?>
      <?php echo wp_get_attachment_image($thumb_id, 'artwork-card', false, [
        'loading' => 'lazy',
        'class'   => 'artwork-card__img',
      ]); ?>
    <?php else : ?>
      <?php echo gfs_placeholder_img('artwork-card__img', $title); ?>
    <?php endif; ?>

    <!-- Hover overlay -->
    <div class="artwork-card__overlay" aria-hidden="true">
      <div class="artwork-card__overlay-inner">
        <p class="artwork-card__overlay-title"><?php echo esc_html($title); ?></p>
        <p class="artwork-card__overlay-label"><?php echo esc_html($material); ?></p>
        <?php if ($link) : ?>
          <span class="artwork-card__overlay-link"><?php esc_html_e('View Work', 'gf-sculpture'); ?> &rarr;</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Below-image meta -->
  <?php if ($show_meta) : ?>
  <div class="artwork-card__meta">
    <h3 class="artwork-card__title"><?php echo esc_html($title); ?></h3>
    <p>
      <span class="artwork-card__material"><?php echo esc_html($material); ?></span>
      <?php if ($year) : ?>
        <span class="artwork-card__year"><?php echo esc_html($year); ?></span>
      <?php endif; ?>
    </p>
    <?php if ($avail && $avail !== 'available') : ?>
      <span class="availability-badge availability-badge--<?php echo esc_attr($avail); ?>">
        <?php echo esc_html(ucfirst($avail)); ?>
      </span>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</<?php echo $link ? 'a' : 'div'; ?>>
