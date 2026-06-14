</main><!-- /#main -->

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-main">

      <!-- Brand column -->
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo" aria-label="<?php bloginfo('name'); ?> — Home">
          <?php
          $logo_path = get_template_directory() . '/assets/images/logo.svg';
          if (file_exists($logo_path)) {
            echo file_get_contents($logo_path); // phpcs:ignore WordPress.Security.EscapeOutput
          }
          ?>
        </a>
        <p class="footer-tagline">
          <?php echo esc_html(get_bloginfo('description') ?: 'Sculpture by Geoff Fahey — original works in bronze, stone, resin and more.'); ?>
        </p>
        <nav class="footer-social" aria-label="Social media">
          <!-- [PLACEHOLDER: Replace # with actual social URLs] -->
          <a href="#" class="social-link" aria-label="Instagram" rel="noopener noreferrer" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
          </a>
          <a href="#" class="social-link" aria-label="Facebook" rel="noopener noreferrer" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
            </svg>
          </a>
        </nav>
      </div>

      <!-- Nav column -->
      <div class="footer-nav">
        <div>
          <p class="footer-nav__heading"><?php esc_html_e('Navigate', 'gf-sculpture'); ?></p>
          <ul class="footer-nav__links" role="list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="footer-nav__link">Home</a></li>
            <li><a href="<?php echo esc_url(get_post_type_archive_link('artwork')); ?>" class="footer-nav__link">Portfolio</a></li>
            <?php if (class_exists('WooCommerce')) : ?>
            <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="footer-nav__link">Shop</a></li>
            <?php endif; ?>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="footer-nav__link">About</a></li>
            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="footer-nav__link">Contact</a></li>
          </ul>
        </div>
        <div>
          <p class="footer-nav__heading"><?php esc_html_e('Studio', 'gf-sculpture'); ?></p>
          <address class="footer-address">
            <!-- [PLACEHOLDER: Replace with studio address] -->
            G.F. Sculpture Studios<br>
            [Studio Address Line 1]<br>
            [Town, County, Postcode]<br>
            <br>
            <a href="mailto:info@gfsculpturestudios.com">info@gfsculpturestudios.com</a><br>
            <a href="tel:+440000000000">+44 (0)000 000 0000</a>
          </address>
        </div>
      </div>

    </div><!-- /.footer-main -->

    <!-- Bottom bar -->
    <div class="footer-bottom">
      <p class="footer-copyright">
        <?php printf(
          esc_html__('&copy; %s G.F. Sculpture Studios. All rights reserved.', 'gf-sculpture'),
          date_i18n('Y')
        ); ?>
      </p>
      <nav aria-label="Legal">
        <!-- [PLACEHOLDER: Add privacy/cookie links if needed] -->
      </nav>
    </div>

  </div><!-- /.container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
