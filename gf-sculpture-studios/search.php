<?php
/**
 * search.php — search results.
 */
get_template_part('template-parts/header');
?>

  <div class="container search-results">
    <div class="page-header">
      <h1 class="section-heading">
        <?php printf(esc_html__('Search: "%s"', 'gf-sculpture'), get_search_query()); ?>
      </h1>
      <?php if (have_posts()) : ?>
      <p style="color:var(--mid-grey);font-family:var(--font-sans);font-size:0.875rem;margin-top:0.5rem;">
        <?php printf(esc_html__('%d results found', 'gf-sculpture'), $wp_query->found_posts); ?>
      </p>
      <?php endif; ?>
    </div>

    <?php if (have_posts()) : ?>
    <div style="display:grid;gap:2rem;margin-bottom:4rem;">
      <?php while (have_posts()) : the_post(); ?>
      <article style="border-bottom:1px solid var(--divider);padding-bottom:2rem;">
        <p class="label" style="margin-bottom:0.5rem;"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type()); ?></p>
        <h2 style="font-family:var(--font-serif);font-size:1.5rem;font-weight:400;margin-bottom:0.5rem;">
          <a href="<?php the_permalink(); ?>" style="transition:color 0.2s;"><?php the_title(); ?></a>
        </h2>
        <div style="font-size:0.9375rem;color:rgba(28,28,28,0.65);"><?php the_excerpt(); ?></div>
        <a href="<?php the_permalink(); ?>" class="btn btn--ghost" style="margin-top:1rem;"><?php esc_html_e('View', 'gf-sculpture'); ?></a>
      </article>
      <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(); ?>
    <?php else : ?>
    <p style="padding:4rem 0;color:var(--mid-grey);">
      <?php esc_html_e('No results found. Try a different search term.', 'gf-sculpture'); ?>
    </p>
    <?php get_search_form(); ?>
    <?php endif; ?>
  </div>

<?php get_template_part('template-parts/footer'); ?>
