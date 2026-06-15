<?php
/**
 * 404 page.
 */
get_template_part('template-parts/header');
?>

  <div class="error-404 container">
    <p class="error-404__code" aria-hidden="true">404</p>
    <span class="label" style="margin-bottom:1rem;"><?php esc_html_e('Page not found', 'gf-sculpture'); ?></span>
    <h1 class="section-heading" style="font-size:clamp(2rem,4vw,3.5rem);margin-bottom:1rem;">
      <?php esc_html_e('This page has wandered off.', 'gf-sculpture'); ?>
    </h1>
    <p style="color:var(--mid-grey);max-width:45ch;margin-bottom:2.5rem;">
      <?php esc_html_e('The work you\'re looking for may have been moved, renamed, or doesn\'t exist. Return to the studio.', 'gf-sculpture'); ?>
    </p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary"><?php esc_html_e('Return Home', 'gf-sculpture'); ?></a>
  </div>

<?php get_template_part('template-parts/footer'); ?>
