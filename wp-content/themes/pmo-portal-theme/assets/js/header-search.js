/**
 * Header Enhancement & Mobile Menu
 * Sticky header with scroll shadow effects and responsive menu
 */

document.addEventListener('DOMContentLoaded', function() {
  const headerWrapper = document.querySelector('.header-wrapper');
  let ticking = false;

  function updateHeader() {
    const currentScrollY = window.scrollY;

    // Add shadow effect on scroll for better depth perception
    if (currentScrollY > 50) {
      headerWrapper.classList.add('scrolled');
    } else {
      headerWrapper.classList.remove('scrolled');
    }

    ticking = false;
  }

  window.addEventListener('scroll', function() {
    if (!ticking) {
      window.requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }, { passive: true });

  // Mobile menu toggle
  const mobileToggle = document.getElementById('mobile-menu-toggle');
  const mainNav = document.getElementById('site-navigation');

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function() {
      mainNav.classList.toggle('active');
      this.querySelector('span').textContent = mainNav.classList.contains('active') ? '✕' : '☰';
    });

    // Close menu on link click
    const menuLinks = mainNav.querySelectorAll('a');
    menuLinks.forEach(link => {
      link.addEventListener('click', function() {
        mainNav.classList.remove('active');
        mobileToggle.querySelector('span').textContent = '☰';
      });
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && mainNav.classList.contains('active')) {
        mainNav.classList.remove('active');
        mobileToggle.querySelector('span').textContent = '☰';
      }
    });
  }
});
