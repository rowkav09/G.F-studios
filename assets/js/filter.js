/**
 * G.F. Sculpture Studios — filter.js
 * Portfolio and shop JS filtering with GSAP layout transition.
 * Filters by [data-material] attribute on artwork cards.
 */

(function () {
  'use strict';

  function initFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const grid       = document.querySelector('.portfolio-grid, [data-filter-grid]');

    if (!filterBtns.length || !grid) return;

    const allCards = Array.from(grid.querySelectorAll('[data-material], .artwork-card[data-filter]'));

    function filterCards(material) {
      const useGsap = typeof gsap !== 'undefined' && !window.gfsPrefersReducedMotion;

      if (useGsap) {
        // Fade whole grid
        gsap.to(grid, {
          opacity: 0.4,
          duration: 0.2,
          onComplete: () => applyFilter(material, useGsap),
        });
      } else {
        applyFilter(material, false);
      }
    }

    function applyFilter(material, useGsap) {
      let visibleCards = [];

      allCards.forEach((card) => {
        const cardMaterial = (card.dataset.material || '').toLowerCase();
        const show = material === 'all' || cardMaterial === material;

        if (show) {
          card.style.display = '';
          card.removeAttribute('data-hidden');
          visibleCards.push(card);
        } else {
          card.style.display = 'none';
          card.setAttribute('data-hidden', '');
        }
      });

      if (useGsap && visibleCards.length) {
        gsap.fromTo(
          visibleCards,
          { opacity: 0, y: 16 },
          {
            opacity: 1,
            y: 0,
            duration: 0.55,
            stagger: 0.07,
            ease: 'power2.out',
            onStart: () => gsap.to(grid, { opacity: 1, duration: 0.2 }),
          }
        );
      } else {
        grid.style.opacity = '1';
      }
    }

    filterBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const material = (btn.dataset.filter || 'all').toLowerCase();

        // Update active state
        filterBtns.forEach((b) => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        filterCards(material);

        // Update URL hash without scrolling (for bookmarkability)
        if (history.replaceState) {
          const hash = material === 'all' ? '' : `#material=${material}`;
          history.replaceState(null, '', window.location.pathname + window.location.search + hash);
        }
      });
    });

    // ── LOAD MORE ──────────────────────────────
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (loadMoreBtn) {
      const perPage      = parseInt(loadMoreBtn.dataset.perPage || '6', 10);
      let   currentShown = perPage;
      const allItems     = Array.from(grid.querySelectorAll('.artwork-card, [data-filterable]'));

      // Hide items beyond perPage on load
      allItems.forEach((item, i) => {
        if (i >= perPage) item.style.display = 'none';
      });

      if (allItems.length <= perPage) {
        loadMoreBtn.style.display = 'none';
      }

      loadMoreBtn.addEventListener('click', () => {
        const nextBatch = allItems.slice(currentShown, currentShown + perPage);
        nextBatch.forEach((item) => {
          item.style.display = '';
        });

        if (typeof gsap !== 'undefined' && !window.gfsPrefersReducedMotion) {
          gsap.from(nextBatch, {
            opacity: 0,
            y: 20,
            duration: 0.6,
            stagger: 0.08,
            ease: 'power2.out',
          });
        }

        currentShown += perPage;

        if (currentShown >= allItems.length) {
          loadMoreBtn.style.display = 'none';
        }
      });
    }

    // ── RESTORE FROM URL HASH ──────────────────
    function restoreFromHash() {
      const hash = window.location.hash;
      if (!hash) return;
      const match = hash.match(/material=([^&]+)/);
      if (!match) return;
      const material = match[1];
      const btn = document.querySelector(`.filter-btn[data-filter="${material}"]`);
      if (btn) btn.click();
    }

    restoreFromHash();
  }

  document.addEventListener('DOMContentLoaded', initFilter);

})();
