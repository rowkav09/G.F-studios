/**
 * G.F. Sculpture Studios — animations.js
 * All GSAP scroll animations: SplitText reveals, parallax,
 * fade-ins, horizontal scroll, gallery hover.
 * Runs after main.js.
 */

(function () {
  'use strict';

  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

  const reduced = window.gfsPrefersReducedMotion;

  // If reduced motion: show all hidden elements immediately and exit
  if (reduced) {
    document.querySelectorAll('[data-reveal],[data-reveal-left],[data-reveal-right],[data-reveal-scale]').forEach((el) => {
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
    return;
  }

  // ── HELPERS ──────────────────────────────────

  /**
   * Split element text into line-wrapped spans for reveal animation.
   * Falls back to word-based split if SplitText unavailable.
   */
  function splitTextLines(el) {
    if (typeof SplitText !== 'undefined') {
      const split = new SplitText(el, { type: 'lines', linesClass: 'split-line' });
      // Wrap each line in an overflow:hidden container
      split.lines.forEach((line) => {
        const wrap = document.createElement('span');
        wrap.className = 'line-wrap';
        line.parentNode.insertBefore(wrap, line);
        wrap.appendChild(line);
      });
      return split.lines;
    }

    // Fallback: treat whole element as one line
    el.innerHTML = `<span class="line-wrap"><span class="split-line">${el.innerHTML}</span></span>`;
    return el.querySelectorAll('.split-line');
  }

  // ── SECTION HEADING REVEALS ──────────────────
  function initHeadingReveals() {
    const headings = document.querySelectorAll('.section-heading, .hero__artist-name, .about-hero__name');

    headings.forEach((el) => {
      const lines = splitTextLines(el);

      gsap.from(lines, {
        yPercent: 110,
        opacity: 0,
        duration: 1.0,
        ease: 'power3.out',
        stagger: 0.12,
        scrollTrigger: {
          trigger: el,
          start: 'top 88%',
          toggleActions: 'play none none none',
        },
      });
    });
  }

  // ── INTRO STATEMENT ──────────────────────────
  function initIntroStatement() {
    const el = document.querySelector('.intro-statement');
    if (!el) return;

    const lines = splitTextLines(el);

    gsap.from(lines, {
      yPercent: 100,
      opacity: 0,
      duration: 1.1,
      ease: 'power3.out',
      stagger: 0.1,
      scrollTrigger: {
        trigger: el,
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
    });
  }

  // ── GENERIC FADE-UP REVEALS ──────────────────
  function initFadeReveals() {
    // Individual elements
    gsap.utils.toArray('[data-reveal]').forEach((el) => {
      gsap.fromTo(el,
        { opacity: 0, y: 28 },
        {
          opacity: 1,
          y: 0,
          duration: 0.9,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: el,
            start: 'top 88%',
            toggleActions: 'play none none none',
          },
        }
      );
    });

    gsap.utils.toArray('[data-reveal-left]').forEach((el) => {
      gsap.fromTo(el,
        { opacity: 0, x: -28 },
        {
          opacity: 1,
          x: 0,
          duration: 0.9,
          ease: 'power2.out',
          scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
        }
      );
    });

    gsap.utils.toArray('[data-reveal-right]').forEach((el) => {
      gsap.fromTo(el,
        { opacity: 0, x: 28 },
        {
          opacity: 1,
          x: 0,
          duration: 0.9,
          ease: 'power2.out',
          scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
        }
      );
    });

    gsap.utils.toArray('[data-reveal-scale]').forEach((el) => {
      gsap.fromTo(el,
        { opacity: 0, scale: 0.96 },
        {
          opacity: 1,
          scale: 1,
          duration: 0.9,
          ease: 'power2.out',
          scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
        }
      );
    });
  }

  // ── STAGGERED GRID REVEALS ───────────────────
  function initGridReveals() {
    const grids = document.querySelectorAll('.artwork-grid, .portfolio-grid, .product-grid, .studio-grid');

    grids.forEach((grid) => {
      const items = grid.children;
      gsap.fromTo(items,
        { opacity: 0, y: 32 },
        {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power2.out',
          stagger: 0.1,
          scrollTrigger: {
            trigger: grid,
            start: 'top 85%',
            toggleActions: 'play none none none',
          },
        }
      );
    });
  }

  // ── HERO PARALLAX ────────────────────────────
  function initHeroParallax() {
    const heroBg = document.querySelector('.hero__bg img, .hero__bg .img-placeholder');
    if (!heroBg) return;

    gsap.to(heroBg, {
      yPercent: 25,
      ease: 'none',
      scrollTrigger: {
        trigger: '.hero',
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    });
  }

  // ── STATEMENT PIECE PARALLAX ─────────────────
  function initStatementParallax() {
    const img = document.querySelector('.statement-piece__image img, .statement-piece__image .img-placeholder');
    if (!img) return;

    gsap.to(img, {
      yPercent: 15,
      ease: 'none',
      scrollTrigger: {
        trigger: '.statement-piece',
        start: 'top bottom',
        end: 'bottom top',
        scrub: true,
      },
    });

    // Content fade in
    const content = document.querySelector('.statement-piece__content');
    if (content) {
      gsap.from(content.children, {
        opacity: 0,
        y: 24,
        duration: 0.8,
        stagger: 0.12,
        scrollTrigger: {
          trigger: content,
          start: 'top 78%',
          toggleActions: 'play none none none',
        },
      });
    }
  }

  // ── HORIZONTAL SCROLL ────────────────────────
  function initHorizontalScroll() {
    const section = document.querySelector('.h-scroll-section');
    const track   = document.querySelector('.h-scroll-track');
    if (!section || !track) return;

    // Disable on mobile (CSS handles vertical stacking)
    const mq = window.matchMedia('(max-width: 768px)');
    if (mq.matches) return;

    const totalWidth   = track.scrollWidth;
    const viewportWidth = section.offsetWidth;
    const scrollDist    = totalWidth - viewportWidth;

    const st = ScrollTrigger.create({
      trigger: section,
      start: 'top top',
      end: `+=${scrollDist}`,
      pin: true,
      anticipatePin: 1,
      scrub: 1.2,
      onUpdate: (self) => {
        gsap.set(track, { x: -(self.progress * scrollDist) });
        if (window.updateHScrollProgress) {
          window.updateHScrollProgress(self.progress);
        }
      },
    });

    // Recalculate on resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (!window.matchMedia('(max-width: 768px)').matches) {
          st.refresh();
        }
      }, 250);
    });
  }

  // ── MATERIAL STRIP STAGGER ───────────────────
  function initMaterialStrip() {
    const tags = document.querySelectorAll('.material-tag');
    if (!tags.length) return;

    gsap.from(tags, {
      opacity: 0,
      y: 10,
      duration: 0.5,
      stagger: 0.07,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: '.material-strip',
        start: 'top 88%',
        toggleActions: 'play none none none',
      },
    });
  }

  // ── ABOUT SNIPPET ────────────────────────────
  function initAboutSnippet() {
    const snippet = document.querySelector('.about-snippet');
    if (!snippet) return;

    gsap.from('.about-snippet__image', {
      opacity: 0,
      x: -32,
      duration: 1.0,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: snippet,
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
    });

    gsap.from('.about-snippet__content > *', {
      opacity: 0,
      y: 24,
      duration: 0.8,
      stagger: 0.12,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: '.about-snippet__content',
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
    });
  }

  // ── TIMELINE ENTRIES ─────────────────────────
  function initTimeline() {
    const entries = document.querySelectorAll('.timeline-entry');
    if (!entries.length) return;

    entries.forEach((entry, i) => {
      const isOdd = i % 2 === 0;
      gsap.from(entry.querySelector('.timeline-entry__content'), {
        opacity: 0,
        x: isOdd ? -24 : 24,
        duration: 0.8,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: entry,
          start: 'top 85%',
          toggleActions: 'play none none none',
        },
      });

      gsap.from(entry.querySelector('.timeline-entry__dot'), {
        scale: 0,
        duration: 0.5,
        ease: 'back.out(2)',
        scrollTrigger: {
          trigger: entry,
          start: 'top 85%',
          toggleActions: 'play none none none',
        },
      });
    });
  }

  // ── COMMISSION SECTION ───────────────────────
  function initCommissionCta() {
    const section = document.querySelector('.commission-cta');
    if (!section) return;

    gsap.from(section.querySelectorAll('.section-heading, p, .btn'), {
      opacity: 0,
      y: 20,
      duration: 0.8,
      stagger: 0.1,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: section,
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
    });
  }

  // ── SINGLE ARTWORK ───────────────────────────
  function initSingleArtwork() {
    const layout = document.querySelector('.single-artwork-layout');
    if (!layout) return;

    gsap.from('.artwork-gallery', {
      opacity: 0,
      x: -24,
      duration: 0.9,
      ease: 'power2.out',
    });

    gsap.from('.artwork-details > *', {
      opacity: 0,
      y: 20,
      duration: 0.7,
      stagger: 0.1,
      ease: 'power2.out',
      delay: 0.2,
    });
  }

  // ── INIT ALL ─────────────────────────────────
  function init() {
    initHeadingReveals();
    initIntroStatement();
    initFadeReveals();
    initGridReveals();
    initHeroParallax();
    initStatementParallax();
    initHorizontalScroll();
    initMaterialStrip();
    initAboutSnippet();
    initTimeline();
    initCommissionCta();
    initSingleArtwork();

    // Refresh ScrollTrigger after images load
    window.addEventListener('load', () => ScrollTrigger.refresh());
  }

  document.addEventListener('DOMContentLoaded', init);

})();
