<?php
/**
 * Hero section — full viewport, parallax image, artist name.
 * Used on front-page.php and page-about.php (with modifier class).
 *
 * @var string $hero_class  Additional CSS class for the hero (optional)
 * @var array  $hero_image  ACF image array (optional — falls back to placeholder)
 */
$hero_class = isset($args['hero_class']) ? ' ' . $args['hero_class'] : '';
$hero_image = isset($args['hero_image']) ? $args['hero_image'] : gfs_field('hp_hero_image', get_the_ID());
?>

<section class="hero<?php echo esc_attr($hero_class); ?>" aria-label="<?php esc_attr_e('Hero', 'gf-sculpture'); ?>">

  <!-- Background image with parallax target -->
  <div class="hero__bg parallax-img">
    <?php if (!empty($hero_image) && !empty($hero_image['url'])) : ?>
      <img
        src="<?php echo esc_url($hero_image['sizes']['hero-full'] ?? $hero_image['url']); ?>"
        alt="<?php echo esc_attr($hero_image['alt'] ?? ''); ?>"
        loading="eager"
        fetchpriority="high"
        width="1920"
        height="1080"
      >
    <?php else : ?>
      <?php echo gfs_placeholder_img('hero__placeholder', 'Geoff Fahey sculpture'); ?>
    <?php endif; ?>
  </div>

  <!-- Text content -->
  <div class="hero__content">
    <div class="container">
      <p class="hero__subtitle label" data-reveal>
        <!-- [PLACEHOLDER: 'Sculptor' or 'Artist & Sculptor'] -->
        <?php esc_html_e('Sculptor', 'gf-sculpture'); ?>
      </p>
      <h1 class="hero__artist-name">
        <!-- [PLACEHOLDER: Geoff Fahey's name — split across two lines for dramatic effect] -->
        Geoff<br>Fahey
      </h1>
      <div class="hero__scroll-cue" aria-hidden="true">
        <span class="hero__scroll-line"></span>
        <span><?php esc_html_e('Scroll', 'gf-sculpture'); ?></span>
      </div>
    </div>
  </div>

</section>
