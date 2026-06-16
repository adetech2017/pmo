/**
 * PMO Portal Theme - Animations & Interactions
 * Scroll reveals, parallax, and interactive effects
 */

document.addEventListener('DOMContentLoaded', function() {
  // Scroll Reveal Animation
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observe all sections, cards, and headers
  document.querySelectorAll('.section-header, .foundation-card, .impact-card, .grid > div').forEach(el => {
    observer.observe(el);
  });

  // Parallax effect on hero section
  const heroSection = document.querySelector('.hero-carousel');
  if (heroSection) {
    window.addEventListener('scroll', function() {
      const scrolled = window.pageYOffset;
      heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
    });
  }

  // Staggered animation for grid items
  document.querySelectorAll('.grid').forEach(grid => {
    const cards = grid.querySelectorAll('> div');
    cards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.15}s`;
    });
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href !== '#' && document.querySelector(href)) {
        e.preventDefault();
        document.querySelector(href).scrollIntoView({
          behavior: 'smooth'
        });
      }
    });
  });
});
