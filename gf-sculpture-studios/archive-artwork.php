<?php
/**
 * Portfolio archive — archive-artwork.php
 * Filter bar + 3-column grid + Load More.
 */
get_template_part('template-parts/header');
?>

  <!-- Archive header -->
  <div class="archive-header container">
    <span class="label section-label" data-reveal><?php esc_html_e('G.F. Sculpture Studios', 'gf-sculpture'); ?></span>
    <h1 class="archive-header__heading section-heading" data-reveal>
      <?php esc_html_e('Portfolio', 'gf-sculpture'); ?>
    </h1>
    <p data-reveal style="color:var(--mid-grey);font-size:0.9375rem;margin-top:0.5rem;">
      <!-- [PLACEHOLDER: Short portfolio intro line, e.g. count of works or a tagline] -->
      <?php printf(esc_html__('%d works across bronze, stone, resin, steel and more.', 'gf-sculpture'), wp_count_posts('artwork')->publish); ?>
    </p>
  </div>

  <div class="container">

    <!-- Filter bar -->
    <nav class="filter-bar" aria-label="<?php esc_attr_e('Filter by material', 'gf-sculpture'); ?>">
      <button class="filter-btn is-active" data-filter="all" aria-pressed="true"><?php esc_html_e('All', 'gf-sculpture'); ?></button>
      <?php
      $materials = [
        'bronze'  => 'Bronze',
        'stone'   => 'Stone',
        'resin'   => 'Resin',
        'steel'   => 'Steel',
        'wood'    => 'Wood',
        'ceramic' => 'Ceramic',
      ];
      foreach ($materials as $slug => $label) {
        printf(
          '<button class="filter-btn" data-filter="%s" aria-pressed="false">%s</button>',
          esc_attr($slug),
          esc_html($label)
        );
      }
      ?>
    </nav>

    <!-- Artwork grid -->
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $artworks_query = new WP_Query([
      'post_type'      => 'artwork',
      'posts_per_page' => -1, // Load all; JS handles load-more client-side
      'post_status'    => 'publish',
      'orderby'        => 'menu_order date',
      'order'          => 'ASC',
    ]);
    ?>

    <?php if ($artworks_query->have_posts()) : ?>
    <div class="portfolio-grid" data-filter-grid>
      <?php while ($artworks_query->have_posts()) : $artworks_query->the_post(); ?>
        <?php get_template_part('template-parts/artwork-card', null, ['post' => get_post()]); ?>
      <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>

    <!-- Load More (JS-driven, shows 12 at a time) -->
    <div class="load-more-wrap" data-reveal>
      <button class="load-more-btn btn btn--ghost" data-per-page="12">
        <?php esc_html_e('Load More Works', 'gf-sculpture'); ?>
      </button>
    </div>

    <?php else : ?>
    <p style="color:var(--mid-grey);padding-block:4rem;text-align:center;">
      <?php esc_html_e('No artworks found. Add some in the WordPress admin.', 'gf-sculpture'); ?>
    </p>
    <?php endif; ?>

  </div><!-- /.container -->

<?php get_template_part('template-parts/footer'); ?>
