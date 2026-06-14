/**
 * G.F. Sculpture Studios — cursor.js
 * Custom bronze cursor: dot + trailing ring.
 * Disabled on touch devices and reduced-motion.
 */

(function () {
  'use strict';

  // Don't run on touch-primary devices
  const isTouch     = window.matchMedia('(hover: none)').matches;
  const isReduced   = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (isTouch || isReduced) return;

  // ── CREATE CURSOR ELEMENTS ───────────────────
  const dot  = document.createElement('div');
  const ring = document.createElement('div');
  dot.className  = 'cursor-dot';
  ring.className = 'cursor-ring';
  document.body.appendChild(dot);
  document.body.appendChild(ring);

  // ── STATE ────────────────────────────────────
  let mouseX = -100;
  let mouseY = -100;
  let ringX  = -100;
  let ringY  = -100;
  let rafId;

  // ── MOUSE MOVE ───────────────────────────────
  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // ── ANIMATION LOOP ───────────────────────────
  function animateCursor() {
    // Dot follows instantly
    dot.style.left  = mouseX + 'px';
    dot.style.top   = mouseY + 'px';

    // Ring lags behind with lerp
    const speed = 0.12;
    ringX += (mouseX - ringX) * speed;
    ringY += (mouseY - ringY) * speed;
    ring.style.left = ringX + 'px';
    ring.style.top  = ringY + 'px';

    rafId = requestAnimationFrame(animateCursor);
  }

  rafId = requestAnimationFrame(animateCursor);

  // ── HOVER STATES ─────────────────────────────
  const hoverSelectors = 'a, button, .artwork-card, .product-card, .material-tag, .filter-btn, .artwork-thumb, .h-scroll-card, .artwork-gallery__primary, [data-cursor-hover]';

  function addHoverListeners() {
    document.querySelectorAll(hoverSelectors).forEach((el) => {
      el.addEventListener('mouseenter', onEnter);
      el.addEventListener('mouseleave', onLeave);
    });
  }

  function onEnter() {
    dot.classList.add('is-hovering');
    ring.classList.add('is-hovering');
  }

  function onLeave() {
    dot.classList.remove('is-hovering');
    ring.classList.remove('is-hovering');
  }

  // ── CLICK STATE ──────────────────────────────
  document.addEventListener('mousedown', () => {
    dot.classList.add('is-clicking');
  });

  document.addEventListener('mouseup', () => {
    dot.classList.remove('is-clicking');
  });

  // ── CURSOR VISIBILITY ────────────────────────
  document.addEventListener('mouseleave', () => {
    dot.style.opacity  = '0';
    ring.style.opacity = '0';
  });

  document.addEventListener('mouseenter', () => {
    dot.style.opacity  = '1';
    ring.style.opacity = '0.6';
  });

  // ── OBSERVE DOM CHANGES (for dynamic content) ─
  const observer = new MutationObserver(() => addHoverListeners());
  observer.observe(document.body, { childList: true, subtree: true });

  // ── INIT ─────────────────────────────────────
  document.addEventListener('DOMContentLoaded', addHoverListeners);

})();
