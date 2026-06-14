<?php
/**
 * About page — page-about.php
 * Full-viewport portrait hero, bio, timeline, studio grid.
 */
get_template_part('template-parts/header');
the_post();
?>

  <!-- ── ABOUT HERO ─────────────────────────── -->
  <section class="about-hero" aria-label="<?php esc_attr_e('Geoff Fahey — sculptor', 'gf-sculpture'); ?>">
    <div class="about-hero__image">
      <!-- [PLACEHOLDER: Large portrait of Geoff Fahey — minimum 1400px wide] -->
      <?php echo gfs_placeholder_img('', 'Geoff Fahey, sculptor'); ?>
    </div>
    <div class="about-hero__content">
      <div class="container">
        <p class="hero__subtitle label" data-reveal><?php esc_html_e('Sculptor', 'gf-sculpture'); ?></p>
        <h1 class="about-hero__name">Geoff<br>Fahey</h1>
      </div>
    </div>
  </section>

  <!-- ── BIO ───────────────────────────────── -->
  <section class="about-bio section" aria-label="<?php esc_attr_e('Biography', 'gf-sculpture'); ?>">
    <div class="container container--narrow">

      <?php if (get_the_content()) : ?>
        <div class="about-bio__text" data-reveal>
          <?php the_content(); ?>
        </div>
      <?php else : ?>
        <div class="about-bio__text" data-reveal>
          <!-- [PLACEHOLDER: Replace with Geoff's full biography — 3–5 paragraphs] -->
          <p>Geoff Fahey has been creating sculpture for over [X] years, working from his studio in [Location]. His practice spans intimate figurative works and large-scale public commissions, always rooted in a deep understanding of material and form.</p>
          <p>Trained at [Art College/University], Geoff's early work explored [theme]. Over time his practice evolved to encompass [materials and themes], informed by [influences — landscape, architecture, the human body, etc.].</p>
          <p>His sculptures have been exhibited at [Gallery/Exhibition names], and are held in collections in [Countries/Institutions]. He has completed public commissions for [Bodies/Organisations].</p>
        </div>
      <?php endif; ?>

      <!-- Pull quote -->
      <blockquote class="about-bio__pullquote" data-reveal>
        <!-- [PLACEHOLDER: Powerful quote from Geoff] -->
        "Every mark is a conversation between intention and accident."
      </blockquote>

      <div class="about-bio__text" data-reveal>
        <p><!-- [PLACEHOLDER: Continued bio or process description] -->
          Today, Geoff works primarily in [main materials], though his studio practice remains exploratory — driven by curiosity about what happens when form meets resistance. He works to commission and accepts a limited number of new commissions each year.</p>
      </div>

    </div>
  </section>

  <!-- ── EXHIBITION / CAREER TIMELINE ─────── -->
  <section class="timeline section section--off-white" aria-label="<?php esc_attr_e('Career timeline', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="section-header" style="text-align:center;">
        <span class="label section-label" data-reveal><?php esc_html_e('Career', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal><?php esc_html_e('Selected Exhibitions & Awards', 'gf-sculpture'); ?></h2>
      </div>
      <div class="timeline__inner">
        <!-- [PLACEHOLDER: Replace with real timeline entries] -->
        <?php
        $timeline_entries = [
          ['year' => '2024', 'title' => '[Exhibition Name]',  'text' => '[Gallery Name], [City]'],
          ['year' => '2023', 'title' => '[Commission Name]',  'text' => '[Client/Location]'],
          ['year' => '2021', 'title' => '[Award/Shortlist]',  'text' => '[Award body]'],
          ['year' => '2019', 'title' => '[Solo Exhibition]',  'text' => '[Gallery Name], [City]'],
          ['year' => '2017', 'title' => '[Group Exhibition]', 'text' => '[Gallery Name], [City]'],
          ['year' => '2014', 'title' => '[Public Commission]','text' => '[Location or Client]'],
        ];
        foreach ($timeline_entries as $entry) : ?>
        <div class="timeline-entry">
          <div class="timeline-entry__content">
            <span class="timeline-entry__year"><?php echo esc_html($entry['year']); ?></span>
            <p class="timeline-entry__title"><?php echo esc_html($entry['title']); ?></p>
            <p class="timeline-entry__text"><?php echo esc_html($entry['text']); ?></p>
          </div>
          <div class="timeline-entry__dot" aria-hidden="true"></div>
          <div class="timeline-entry__empty"></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── STUDIO GRID ─────────────────────── -->
  <section class="section" aria-label="<?php esc_attr_e('Studio and process photographs', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="section-header">
        <span class="label section-label" data-reveal><?php esc_html_e('Process', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal><?php esc_html_e('In the Studio', 'gf-sculpture'); ?></h2>
      </div>
      <div class="studio-grid">
        <!-- [PLACEHOLDER: Replace with 6–9 studio/process photos] -->
        <?php for ($i = 0; $i < 6; $i++) : ?>
          <div class="studio-grid__item">
            <?php echo gfs_placeholder_img('', 'Studio process photograph ' . ($i + 1)); ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- ── CTAs ──────────────────────────── -->
  <section class="section section--off-white" style="text-align:center;" aria-label="<?php esc_attr_e('Explore further', 'gf-sculpture'); ?>">
    <div class="container">
      <h2 class="section-heading" data-reveal style="margin-bottom:2rem;">
        <?php esc_html_e('Explore the Work', 'gf-sculpture'); ?>
      </h2>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;" data-reveal>
        <a href="<?php echo esc_url(get_post_type_archive_link('artwork')); ?>" class="btn btn--primary">
          <?php esc_html_e('View the Collection', 'gf-sculpture'); ?>
        </a>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn--ghost">
          <?php esc_html_e('Get in Touch', 'gf-sculpture'); ?>
        </a>
      </div>
    </div>
  </section>

<?php get_template_part('template-parts/footer'); ?>
