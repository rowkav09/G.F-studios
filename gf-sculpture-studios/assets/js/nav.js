/**
 * G.F. Sculpture Studios — nav.js
 * Mobile overlay nav, hamburger, page transitions.
 */

(function () {
  'use strict';

  // ── OVERLAY NAV ──────────────────────────────
  function initNav() {
    const hamburger = document.querySelector('.hamburger');
    const overlay   = document.querySelector('.nav-overlay');
    const body      = document.body;

    if (!hamburger || !overlay) return;

    function openNav() {
      overlay.classList.add('is-open');
      hamburger.setAttribute('aria-expanded', 'true');
      hamburger.setAttribute('aria-label', 'Close menu');
      body.style.overflow = 'hidden';
      // Pause Lenis
      if (window.lenisInstance) window.lenisInstance.stop();
    }

    function closeNav() {
      overlay.classList.remove('is-open');
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.setAttribute('aria-label', 'Open menu');
      body.style.overflow = '';
      if (window.lenisInstance) window.lenisInstance.start();
    }

    hamburger.addEventListener('click', () => {
      const isOpen = overlay.classList.contains('is-open');
      isOpen ? closeNav() : openNav();
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
        closeNav();
        hamburger.focus();
      }
    });

    // Close when clicking a nav link
    overlay.querySelectorAll('.nav-overlay__link').forEach((link) => {
      link.addEventListener('click', closeNav);
    });

    // Focus trap inside overlay when open
    overlay.addEventListener('keydown', (e) => {
      if (!overlay.classList.contains('is-open')) return;
      const focusable = overlay.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
      const first = focusable[0];
      const last  = focusable[focusable.length - 1];

      if (e.key === 'Tab') {
        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault();
          last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    });
  }

  // ── PAGE TRANSITIONS ─────────────────────────
  function initPageTransitions() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    // Create transition overlay
    const overlay = document.createElement('div');
    overlay.className = 'page-transition';
    document.body.appendChild(overlay);

    // Intercept internal link clicks
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a');
      if (!link) return;

      const href = link.getAttribute('href');
      if (!href) return;

      // Skip: external links, anchors, downloads, special protocols
      const isExternal   = link.hostname !== window.location.hostname;
      const isAnchor     = href.startsWith('#');
      const isDownload   = link.hasAttribute('download');
      const isSpecial    = href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:');
      const isAdminLink  = href.includes('/wp-admin') || href.includes('/wp-login');
      const isCartAction = href.includes('add-to-cart') || href.includes('?removed_item');

      if (isExternal || isAnchor || isDownload || isSpecial || isAdminLink || isCartAction) return;

      e.preventDefault();

      // Fade in white overlay, then navigate
      overlay.style.transition = 'opacity 0.35s ease';
      overlay.style.opacity    = '1';
      overlay.style.pointerEvents = 'all';

      setTimeout(() => {
        window.location.href = href;
      }, 380);
    });

    // Fade out overlay on page show (back/forward cache)
    window.addEventListener('pageshow', () => {
      overlay.style.transition = 'none';
      overlay.style.opacity    = '0';
      overlay.style.pointerEvents = 'none';
      // Re-enable after a tick
      requestAnimationFrame(() => {
        overlay.style.transition = 'opacity 0.35s ease';
      });
    });
  }

  // ── INIT ─────────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    initNav();
    initPageTransitions();
  });

})();
