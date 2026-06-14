<?php
/**
 * Contact page — page-contact.php
 * Two-column: address/map left, Contact Form 7 right.
 */
get_template_part('template-parts/header');
the_post();
?>

  <!-- Contact layout -->
  <div class="container">
    <div class="contact-layout">

      <!-- ── LEFT: Info + Map ──────────── -->
      <div class="contact-info">
        <span class="label section-label" data-reveal><?php esc_html_e('Get in Touch', 'gf-sculpture'); ?></span>
        <h1 class="contact-info__heading section-heading" data-reveal>
          <?php esc_html_e('Studio Contact', 'gf-sculpture'); ?>
        </h1>

        <address data-reveal>
          <!-- [PLACEHOLDER: Replace with studio address and contact details] -->
          <strong>G.F. Sculpture Studios</strong><br>
          [Studio Address Line 1]<br>
          [Town, County]<br>
          [Postcode]<br>
          <br>
          <a href="mailto:info@gfsculpturestudios.com">info@gfsculpturestudios.com</a><br>
          <a href="tel:+440000000000">+44 (0)000 000 0000</a><br>
          <br>
          <!-- [PLACEHOLDER: Studio opening/visiting hours if applicable] -->
          Studio visits by appointment only.
        </address>

        <!-- Google Map embed -->
        <div class="map-embed" data-reveal>
          <!-- [PLACEHOLDER: Replace with actual Google Maps embed code] -->
          <!-- To generate: maps.google.com → Share → Embed a map → Copy HTML -->
          <div style="width:100%;height:100%;background:var(--off-white);display:flex;align-items:center;justify-content:center;">
            <p style="color:var(--mid-grey);font-size:0.75rem;font-family:var(--font-sans);letter-spacing:0.1em;text-transform:uppercase;">
              [PLACEHOLDER: Google Maps embed]
            </p>
          </div>
        </div>
      </div>

      <!-- ── RIGHT: Contact Form ────────── -->
      <div class="contact-form-wrap">
        <span class="label section-label" data-reveal><?php esc_html_e('Send a Message', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal style="font-size:clamp(1.75rem,3vw,3rem);margin-bottom:2rem;">
          <?php esc_html_e('Write to Geoff', 'gf-sculpture'); ?>
        </h2>
        <div data-reveal>
          <?php
          // Contact Form 7 shortcode — replace [ID] with your CF7 form ID
          if (function_exists('wpcf7')) {
            echo do_shortcode('[contact-form-7 id="[PLACEHOLDER_CF7_ID]" title="Contact Form"]');
          } else {
            // Fallback plain HTML form
            ?>
            <form method="post" action="#" class="plain-contact-form" aria-label="<?php esc_attr_e('Contact form', 'gf-sculpture'); ?>">
              <?php wp_nonce_field('gfs_contact', 'gfs_contact_nonce'); ?>
              <div style="margin-bottom:1.25rem;">
                <label for="contact-name" class="label" style="display:block;margin-bottom:0.4rem;"><?php esc_html_e('Name', 'gf-sculpture'); ?></label>
                <input type="text" id="contact-name" name="name" required style="width:100%;border:1px solid var(--divider);padding:0.75rem 1rem;font-family:var(--font-sans);font-size:0.9375rem;background:var(--white);">
              </div>
              <div style="margin-bottom:1.25rem;">
                <label for="contact-email" class="label" style="display:block;margin-bottom:0.4rem;"><?php esc_html_e('Email', 'gf-sculpture'); ?></label>
                <input type="email" id="contact-email" name="email" required style="width:100%;border:1px solid var(--divider);padding:0.75rem 1rem;font-family:var(--font-sans);font-size:0.9375rem;background:var(--white);">
              </div>
              <div style="margin-bottom:1.25rem;">
                <label for="contact-subject" class="label" style="display:block;margin-bottom:0.4rem;"><?php esc_html_e('Subject', 'gf-sculpture'); ?></label>
                <select id="contact-subject" name="subject" style="width:100%;border:1px solid var(--divider);padding:0.75rem 1rem;font-family:var(--font-sans);font-size:0.9375rem;background:var(--white);appearance:none;">
                  <option value="general"><?php esc_html_e('General Enquiry', 'gf-sculpture'); ?></option>
                  <option value="commission"><?php esc_html_e('Commission', 'gf-sculpture'); ?></option>
                  <option value="purchase"><?php esc_html_e('Purchase Enquiry', 'gf-sculpture'); ?></option>
                  <option value="press"><?php esc_html_e('Press', 'gf-sculpture'); ?></option>
                </select>
              </div>
              <div style="margin-bottom:1.5rem;">
                <label for="contact-message" class="label" style="display:block;margin-bottom:0.4rem;"><?php esc_html_e('Message', 'gf-sculpture'); ?></label>
                <textarea id="contact-message" name="message" rows="6" required style="width:100%;border:1px solid var(--divider);padding:0.75rem 1rem;font-family:var(--font-sans);font-size:0.9375rem;background:var(--white);resize:vertical;"></textarea>
              </div>
              <button type="submit" class="btn btn--primary"><?php esc_html_e('Send Message', 'gf-sculpture'); ?></button>
            </form>
            <?php
          }
          ?>
        </div>
      </div>

    </div><!-- /.contact-layout -->
  </div><!-- /.container -->

  <!-- ── COMMISSION EXPLAINER ─────────────── -->
  <section class="commission-explainer section" aria-label="<?php esc_attr_e('About commissions', 'gf-sculpture'); ?>">
    <div class="container">
      <div class="commission-explainer__inner">
        <span class="label section-label" data-reveal><?php esc_html_e('Bespoke Works', 'gf-sculpture'); ?></span>
        <h2 class="section-heading" data-reveal style="font-size:clamp(1.75rem,3vw,3rem);margin-bottom:1.5rem;">
          <?php esc_html_e('The Commission Process', 'gf-sculpture'); ?>
        </h2>
        <div data-reveal>
          <p>
            <!-- [PLACEHOLDER: Describe the commission process in 3–5 sentences] -->
            Every commission begins with a conversation. Geoff likes to understand your space, your intentions, and the feeling you want the work to bring. From there, he develops a proposal — usually including sketches or maquettes — before agreeing on materials, scale, and timeline.
          </p>
          <p>
            Commissions typically take [X–X months] from agreement to delivery. Geoff accepts a limited number each year to ensure each work receives his full attention. Prices for commissions are agreed individually based on scale and complexity.
          </p>
          <p>
            To begin a commission conversation, use the form above or email directly at <a href="mailto:info@gfsculpturestudios.com" style="color:var(--bronze);">info@gfsculpturestudios.com</a>.
          </p>
        </div>
      </div>
    </div>
  </section>

<?php get_template_part('template-parts/footer'); ?>
