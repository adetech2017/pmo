/**
 * PMO Portal Theme - Animations & Interactions
 * Scroll reveals, parallax, and interactive effects.
 * All motion is skipped for users who prefer reduced motion.
 */

document.addEventListener('DOMContentLoaded', function() {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Scroll Reveal Animation
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const revealTargets = document.querySelectorAll('.section-header, .foundation-card, .impact-card, .grid > div');

  if (prefersReducedMotion) {
    revealTargets.forEach(el => el.classList.add('visible'));
  } else {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealTargets.forEach(el => {
      observer.observe(el);
    });

    // Staggered animation for grid items
    document.querySelectorAll('.grid').forEach(grid => {
      const cards = grid.querySelectorAll('> div');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.15}s`;
      });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href !== '#' && document.querySelector(href)) {
        e.preventDefault();
        document.querySelector(href).scrollIntoView({
          behavior: prefersReducedMotion ? 'auto' : 'smooth'
        });
      }
    });
  });
});
