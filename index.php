<?php
/**
 * index.php — fallback template (blog/posts archive).
 */
get_template_part('template-parts/header');
?>

  <div class="container">
    <div class="page-header">
      <span class="label section-label"><?php esc_html_e('G.F. Sculpture Studios', 'gf-sculpture'); ?></span>
      <h1 class="section-heading">
        <?php
        if (is_home() && !is_front_page()) {
          single_post_title();
        } elseif (is_archive()) {
          the_archive_title();
        } else {
          esc_html_e('Latest', 'gf-sculpture');
        }
        ?>
      </h1>
    </div>

    <?php if (have_posts()) : ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2.5rem;margin-bottom:4rem;">
      <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('post-card'); ?>>
        <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" style="display:block;aspect-ratio:3/2;overflow:hidden;margin-bottom:1.25rem;background:var(--off-white);">
          <?php the_post_thumbnail('artwork-card', ['loading' => 'lazy', 'style' => 'width:100%;height:100%;object-fit:cover;']); ?>
        </a>
        <?php endif; ?>
        <h2 style="font-family:var(--font-serif);font-size:1.375rem;font-weight:400;margin-bottom:0.5rem;">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <p style="font-size:0.75rem;color:var(--mid-grey);letter-spacing:0.1em;text-transform:uppercase;font-family:var(--font-sans);margin-bottom:0.75rem;">
          <?php the_date(); ?>
        </p>
        <div style="font-size:0.9375rem;color:rgba(28,28,28,0.7);line-height:1.7;">
          <?php the_excerpt(); ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="btn btn--ghost" style="margin-top:1.25rem;"><?php esc_html_e('Read More', 'gf-sculpture'); ?></a>
      </article>
      <?php endwhile; ?>
    </div>

    <?php the_posts_pagination(['mid_size' => 2]); ?>

    <?php else : ?>
    <p style="padding:4rem 0;color:var(--mid-grey);"><?php esc_html_e('Nothing found.', 'gf-sculpture'); ?></p>
    <?php endif; ?>
  </div>

<?php get_template_part('template-parts/footer'); ?>
