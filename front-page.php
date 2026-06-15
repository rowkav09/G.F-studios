<?php
/**
 * Homepage template — front-page.php
 */
get_template_part('template-parts/header');
?>

  <!-- ── HERO ─────────────────────────────── -->
  <?php get_template_part('template-parts/hero'); ?>

  <!-- ── INTRO LINE ────────────────────────── -->
  <section class="intro-line section" aria-label="<?php esc_attr_e('Studio statement', 'gf-sculpture'); ?>">
    <div class="container">
      <p class="intro-statement">
        <?php echo esc_html(gfs_field('hp_intro_statement', get_the_ID(), 'Form discovered through material, patience, and the hand.')); ?>
      </p>
    </div>
  </section>

  <!-- ── BROWSE BY MATERIAL ────────────────── -->
  <section class="material-strip" aria-label="<?php esc_attr_e('Browse by material', 'gf-sculpture'); ?>">
    <div class="container">
      <nav class="material-tags" aria-label="<?php esc_attr_e('Material filter', 'gf-sculpture'); ?>">
        <?php
        $archive = get_post_type_archive_link('artwork');
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
            '<a href="%s#material=%s" class="material-tag">%s</a>',
            esc_url($archive),
            esc_attr($slug),
            esc_html($label)
          );
        }
        ?>
      </nav>
    </div>
  </section>

  <!-- ── PORTFOLIO TEASER GRID ─────────────── -->
  <section class="portfolio-teaser section" aria-label="<?php esc_attr_e('Portfolio teaser', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="section-header">
        <span class="label section-label" data-reveal><?php esc_html_e('Selected Works', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal><?php esc_html_e('Recent Sculptures', 'gf-sculpture'); ?></h2>
      </div>

      <?php
      $teaser_query = gfs_get_artworks(['posts_per_page' => 6]);
      if ($teaser_query->have_posts()) :
      ?>
      <div class="artwork-grid artwork-grid--asymmetric">
        <?php while ($teaser_query->have_posts()) : $teaser_query->the_post(); ?>
          <?php get_template_part('template-parts/artwork-card', null, ['post' => get_post()]); ?>
        <?php endwhile; ?>
      </div>
      <?php wp_reset_postdata(); endif; ?>

      <div class="section-cta" style="margin-top:3rem;text-align:center;" data-reveal>
        <a href="<?php echo esc_url(get_post_type_archive_link('artwork')); ?>" class="btn btn--ghost">
          <?php esc_html_e('View All Works', 'gf-sculpture'); ?>
        </a>
      </div>
    </div>
  </section>

  <!-- ── STATEMENT PIECE ───────────────────── -->
  <?php get_template_part('template-parts/statement-piece'); ?>

  <!-- ── HORIZONTAL SCROLL — FEATURED WORKS ── -->
  <?php get_template_part('template-parts/horizontal-scroll'); ?>

  <!-- ── ABOUT SNIPPET ─────────────────────── -->
  <section class="about-snippet section" aria-label="<?php esc_attr_e('About Geoff Fahey', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="about-snippet">

        <!-- Portrait image -->
        <div class="about-snippet__image" data-reveal-left>
          <!-- [PLACEHOLDER: Replace with Geoff's studio portrait] -->
          <?php echo gfs_placeholder_img('', 'Geoff Fahey in his studio'); ?>
        </div>

        <!-- Bio text -->
        <div class="about-snippet__content">
          <span class="label section-label" data-reveal><?php esc_html_e('The Sculptor', 'gf-sculpture'); ?></span>
          <h2 class="section-heading" data-reveal><?php esc_html_e('Geoff Fahey', 'gf-sculpture'); ?></h2>
          <blockquote class="about-snippet__quote" data-reveal>
            <!-- [PLACEHOLDER: A short, powerful quote from Geoff about his work] -->
            "The material has a memory. I'm just listening."
          </blockquote>
          <p data-reveal>
            <!-- [PLACEHOLDER: 2–3 sentence intro bio paragraph] -->
            Geoff Fahey has spent over [X] years creating sculptural works that sit between abstraction and the natural world. Working from his studio in [Location], he explores the dialogue between form, weight, and surface. His commissions span public art, gallery exhibitions, and private collections internationally.
          </p>
          <div class="about-snippet__cta" data-reveal>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="btn btn--ghost">
              <?php esc_html_e('About Geoff', 'gf-sculpture'); ?>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ── LATEST FROM THE STUDIO (WooCommerce) ─ -->
  <?php if (class_exists('WooCommerce')) : ?>
  <section class="latest-works section section--off-white" aria-label="<?php esc_attr_e('Latest works available', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="section-header">
        <span class="label section-label" data-reveal><?php esc_html_e('Available Now', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal><?php esc_html_e('Latest from the Studio', 'gf-sculpture'); ?></h2>
      </div>

      <?php
      $products_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'meta_query'     => [['key' => '_stock_status', 'value' => 'instock']],
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);
      ?>

      <?php if ($products_query->have_posts()) : ?>
      <div class="product-grid">
        <?php while ($products_query->have_posts()) : $products_query->the_post();
          $product = wc_get_product(get_the_ID());
          if ($product) {
            get_template_part('template-parts/product-card', null, ['product' => $product]);
          }
        endwhile; ?>
      </div>
      <?php wp_reset_postdata(); endif; ?>

      <div style="text-align:center;margin-top:3rem;" data-reveal>
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--ghost">
          <?php esc_html_e('Visit the Shop', 'gf-sculpture'); ?>
        </a>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ── COMMISSION CTA ─────────────────────── -->
  <section class="commission-cta section" aria-label="<?php esc_attr_e('Commission a work', 'gf-sculpture'); ?>">
    <div class="container">
      <span class="label section-label" data-reveal><?php esc_html_e('Bespoke Works', 'gf-sculpture'); ?></span>
      <h2 class="section-heading" data-reveal><?php esc_html_e('Commission a Work', 'gf-sculpture'); ?></h2>
      <p data-reveal>
        <!-- [PLACEHOLDER: Short paragraph about commissions — process, timescale, types of work available to commission] -->
        Geoff welcomes enquiries for bespoke commissions — from intimate indoor pieces to major public sculptures. Every commission begins with a conversation about your vision, your space, and the lasting presence you want the work to have.
      </p>
      <div data-reveal>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn--primary">
          <?php esc_html_e('Start a Conversation', 'gf-sculpture'); ?>
        </a>
      </div>
    </div>
  </section>

<?php get_template_part('template-parts/footer'); ?>
