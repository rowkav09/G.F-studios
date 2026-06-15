<?php
/**
 * page.php — default page template.
 */
get_template_part('template-parts/header');
the_post();
?>

  <div class="container">
    <div class="page-header">
      <h1 class="section-heading"><?php the_title(); ?></h1>
    </div>
    <div class="container--narrow" style="padding-bottom:5rem;">
      <div style="font-size:1.0625rem;line-height:1.85;color:rgba(28,28,28,0.8);">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

<?php get_template_part('template-parts/footer'); ?>
