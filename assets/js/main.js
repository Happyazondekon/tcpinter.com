/* ============================================================
   TCP Inter – Main JS
   Header scroll, mobile nav, FAQ accordion
   ------------------------------------------------------------
   Design & Development: HeyHappy Digital Agency
   heyhappyproject@gmail.com | +229 01 68 62 87 40
   https://happyazondekon.github.io/
   ============================================================ */

(function () {
  'use strict';

  /* ---------- Header scroll effect ---------- */
  const header = document.querySelector('.site-header');
  if (header) {
    const onScroll = () => {
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Mobile nav toggle ---------- */
  const toggle = document.querySelector('.menu-toggle');
  const nav    = document.querySelector('.primary-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.classList.toggle('is-active');
      nav.classList.toggle('is-open', open);
      toggle.setAttribute('aria-expanded', open);
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close nav when a link is clicked (mobile)
    nav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        toggle.classList.remove('is-active');
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });

    // Close nav on outside click
    document.addEventListener('click', (e) => {
      if (!header.contains(e.target)) {
        toggle.classList.remove('is-active');
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  /* ---------- Testimonials carousel ---------- */
  (function () {
    const carousel = document.querySelector('.testimonials-carousel');
    const track    = document.getElementById('testimonials-track');
    const prevBtn  = document.getElementById('tc-prev');
    const nextBtn  = document.getElementById('tc-next');
    const dots     = document.querySelectorAll('.carousel-dot');
    if (!track || !carousel) return;

    const cards = Array.from(track.querySelectorAll('.testimonial-card'));
    const total = cards.length;
    const GAP   = 24; // 1.5rem at default font-size
    let cols    = window.innerWidth <= 900 ? 1 : 3;
    let current = 0;

    function getStep() {
      // Read actual rendered width from CSS
      return cards[0].getBoundingClientRect().width + GAP;
    }

    function go(index) {
      cols = window.innerWidth <= 900 ? 1 : 3;
      const max = total - cols;
      if (index < 0)   index = max;
      if (index > max) index = 0;
      current = index;
      const step = getStep();
      track.style.transform = 'translateX(-' + (current * step) + 'px)';
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    go(0);
    window.addEventListener('resize', () => go(current));
    prevBtn?.addEventListener('click', () => go(current - cols));
    nextBtn?.addEventListener('click', () => go(current + cols));
    dots.forEach(d => d.addEventListener('click', () => go(+d.dataset.index)));

    // Auto-advance every 6s
    let timer = setInterval(() => go(current + 1), 6000);
    carousel.addEventListener('mouseenter', () => clearInterval(timer));
    carousel.addEventListener('mouseleave', () => {
      timer = setInterval(() => go(current + 1), 6000);
    });
  })();

  /* ---------- Solution card toggle ---------- */
  document.querySelectorAll('.solution-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('aria-controls');
      const panel = document.getElementById(targetId);
      if (!panel) return;

      const isOpen = btn.getAttribute('aria-expanded') === 'true';

      // Close all panels first
      document.querySelectorAll('.solution-toggle').forEach(b => {
        b.setAttribute('aria-expanded', 'false');
        const p = document.getElementById(b.getAttribute('aria-controls'));
        if (p) p.setAttribute('hidden', '');
      });

      // Open this one if it was closed
      if (!isOpen) {
        btn.setAttribute('aria-expanded', 'true');
        panel.removeAttribute('hidden');
        // Smooth scroll to panel
        setTimeout(() => {
          const offset = 90;
          const top = panel.getBoundingClientRect().top + window.scrollY - offset;
          window.scrollTo({ top, behavior: 'smooth' });
        }, 50);
      }
    });
  });

  /* ---------- FAQ accordion ---------- */
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
      const item    = btn.closest('.faq-item');
      const isOpen  = item.classList.contains('is-open');

      // Close all
      document.querySelectorAll('.faq-item.is-open').forEach(open => {
        open.classList.remove('is-open');
        open.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
      });

      // Open clicked (unless it was already open)
      if (!isOpen) {
        item.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });

    // Accessibility
    btn.setAttribute('aria-expanded', 'false');
  });

  /* ---------- Smooth scroll for anchor links ---------- */
  // Handles both same-page `#section` and full-URL `http://…/page/#section` links
  document.querySelectorAll('a[href*="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      let hash;
      try {
        const url = new URL(anchor.href);
        // Different origin – let browser handle
        if (url.origin !== window.location.origin) return;
        // Different path – let browser navigate (it will land on the hash)
        if (url.pathname !== window.location.pathname) return;
        hash = url.hash;
      } catch {
        // Relative anchor like `#section`
        const h = anchor.getAttribute('href');
        if (!h || !h.startsWith('#')) return;
        hash = h;
      }

      if (!hash) return;
      const target = document.querySelector(hash);
      if (target) {
        e.preventDefault();
        // Close mobile nav if open
        document.querySelector('.menu-toggle')?.classList.remove('is-active');
        document.querySelector('.primary-nav')?.classList.remove('is-open');
        document.body.style.overflow = '';

        const offset = 80;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
        history.pushState(null, '', hash);
      }
    });
  });

  /* ---------- Animated counter for stats ---------- */
  const animateCounter = (el) => {
    const target  = parseFloat(el.dataset.target);
    const suffix  = el.dataset.suffix || '';
    const isFloat = target % 1 !== 0;
    const duration = 1600;
    const start = performance.now();

    const step = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3); // ease-out-cubic
      const current = isFloat
        ? (ease * target).toFixed(1)
        : Math.round(ease * target);
      el.textContent = current + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  };

  // Intersection observer for stats section
  const statsNumbers = document.querySelectorAll('.stat-item .number[data-target]');
  if (statsNumbers.length) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.animated) {
          entry.target.dataset.animated = '1';
          animateCounter(entry.target);
        }
      });
    }, { threshold: 0.4 });
    statsNumbers.forEach(n => io.observe(n));
  }

})();
