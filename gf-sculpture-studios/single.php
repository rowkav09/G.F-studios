<?php
/**
 * single.php — default single post.
 */
get_template_part('template-parts/header');
the_post();
?>

  <article <?php post_class('container'); ?> style="padding-top:clamp(7rem,12vw,10rem);padding-bottom:5rem;">
    <header style="max-width:720px;margin-bottom:3rem;">
      <p class="label" style="margin-bottom:1rem;">
        <?php the_category(', '); ?>&ensp;&middot;&ensp;<?php the_date(); ?>
      </p>
      <h1 class="section-heading"><?php the_title(); ?></h1>
    </header>
    <?php if (has_post_thumbnail()) : ?>
    <div style="margin-bottom:3rem;aspect-ratio:16/9;overflow:hidden;background:var(--off-white);">
      <?php the_post_thumbnail('hero-full', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
    </div>
    <?php endif; ?>
    <div class="container--narrow" style="font-size:1.0625rem;line-height:1.9;color:rgba(28,28,28,0.8);">
      <?php the_content(); ?>
    </div>
  </article>

<?php get_template_part('template-parts/footer'); ?>
