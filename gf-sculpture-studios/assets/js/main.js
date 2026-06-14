/**
 * G.F. Sculpture Studios — main.js
 * GSAP registration, Lenis smooth scroll, global init.
 */

(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ── GSAP SETUP ──────────────────────────────
  if (typeof gsap !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);

    if (typeof Observer !== 'undefined') {
      gsap.registerPlugin(Observer);
    }

    // SplitText is a premium plugin — use only if loaded
    if (typeof SplitText !== 'undefined') {
      gsap.registerPlugin(SplitText);
    }

    // Set GSAP defaults
    gsap.defaults({ ease: 'power2.out', duration: 0.8 });
  }

  // ── LENIS SMOOTH SCROLL ──────────────────────
  let lenis = null;

  function initLenis() {
    if (typeof Lenis === 'undefined' || prefersReducedMotion) return;

    lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      touchMultiplier: 1.5,
      infinite: false,
    });

    // Connect Lenis RAF to GSAP ticker
    if (typeof gsap !== 'undefined') {
      gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
      });
      gsap.ticker.lagSmoothing(0);
    } else {
      function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
      }
      requestAnimationFrame(raf);
    }

    // Expose globally for other modules
    window.lenisInstance = lenis;
  }

  // ── PAGE LOAD CURTAIN ────────────────────────
  function initCurtain() {
    const curtain = document.querySelector('.page-curtain');
    if (!curtain) return;

    if (prefersReducedMotion) {
      curtain.remove();
      return;
    }

    if (typeof gsap === 'undefined') {
      curtain.remove();
      return;
    }

    const tl = gsap.timeline({
      onComplete: () => curtain.remove(),
    });

    tl.to(curtain, {
      yPercent: -100,
      duration: 1.2,
      ease: 'power3.inOut',
    });

    // Logo fade-in after curtain starts lifting
    const logo = document.querySelector('.site-logo');
    if (logo) {
      tl.from(logo, { opacity: 0, duration: 0.6 }, '-=0.6');
    }
  }

  // ── HEADER SCROLL BEHAVIOUR ──────────────────
  function initHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    let ticking = false;

    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(() => {
          header.classList.toggle('is-scrolled', window.scrollY > 60);
          ticking = false;
        });
        ticking = true;
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load
  }

  // ── ARTWORK THUMBNAIL GALLERY ────────────────
  function initArtworkGallery() {
    const gallery = document.querySelector('.artwork-gallery');
    if (!gallery) return;

    const primary = gallery.querySelector('.artwork-gallery__primary img');
    const thumbs  = gallery.querySelectorAll('.artwork-thumb');
    const lightboxTrigger = gallery.querySelector('.artwork-gallery__primary');

    thumbs.forEach((thumb) => {
      thumb.addEventListener('click', () => {
        const src  = thumb.querySelector('img')?.src;
        const alt  = thumb.querySelector('img')?.alt || '';
        if (primary && src) {
          primary.src = src;
          primary.alt = alt;
          thumbs.forEach((t) => t.classList.remove('is-active'));
          thumb.classList.add('is-active');
        }
      });
    });

    // Lightbox
    if (lightboxTrigger) {
      lightboxTrigger.addEventListener('click', () => {
        const lightbox = document.querySelector('.lightbox');
        const img      = lightbox?.querySelector('.lightbox__img');
        if (!lightbox || !primary) return;
        if (img) { img.src = primary.src; img.alt = primary.alt; }
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      });
    }

    const lightboxClose = document.querySelector('.lightbox__close');
    const lightbox      = document.querySelector('.lightbox');

    if (lightboxClose && lightbox) {
      lightboxClose.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
      });
    }

    function closeLightbox() {
      lightbox?.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  }

  // ── HORIZONTAL SCROLL PROGRESS ───────────────
  function updateHScrollProgress(progress) {
    const bar = document.querySelector('.h-scroll-progress__bar');
    if (bar) {
      bar.style.transform = `scaleX(${progress})`;
    }
  }

  window.updateHScrollProgress = updateHScrollProgress;

  // ── DOM READY ────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    initLenis();
    initCurtain();
    initHeader();
    initArtworkGallery();

    // Expose reduced motion flag globally
    window.gfsPrefersReducedMotion = prefersReducedMotion;
  });

})();
