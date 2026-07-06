/**
 * Header Enhancement & Mobile Menu
 * Sticky header with scroll shadow effects and responsive menu.
 * This is the single owner of the mobile menu toggle.
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

  if (headerWrapper) {
    window.addEventListener('scroll', function() {
      if (!ticking) {
        window.requestAnimationFrame(updateHeader);
        ticking = true;
      }
    }, { passive: true });
  }

  // Mobile menu toggle
  const mobileToggle = document.getElementById('mobile-menu-toggle');
  const mainNav = document.getElementById('site-navigation');

  if (mobileToggle && mainNav) {
    function setMenuState(open) {
      mainNav.classList.toggle('active', open);
      mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      const icon = mobileToggle.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars', !open);
        icon.classList.toggle('fa-xmark', open);
      }
    }

    mobileToggle.addEventListener('click', function() {
      setMenuState(!mainNav.classList.contains('active'));
    });

    // Close menu on link click
    const menuLinks = mainNav.querySelectorAll('a');
    menuLinks.forEach(link => {
      link.addEventListener('click', function() {
        setMenuState(false);
      });
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && mainNav.classList.contains('active')) {
        setMenuState(false);
        mobileToggle.focus();
      }
    });

    // Reset menu when resizing up to desktop
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768 && mainNav.classList.contains('active')) {
        setMenuState(false);
      }
    });
  }
});

// Site search panel (uses the pmo_search AJAX endpoint)
document.addEventListener('DOMContentLoaded', function() {
  const searchToggle = document.getElementById('header-search-toggle');
  const searchPanel = document.getElementById('header-search-panel');
  const searchInput = document.getElementById('header-search-input');
  const searchResults = document.getElementById('header-search-results');

  if (!searchToggle || !searchPanel || !searchInput || !searchResults || typeof pmoTheme === 'undefined') {
    return;
  }

  let debounceTimer;

  function setSearchOpen(open) {
    searchPanel.hidden = !open;
    searchToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) {
      searchInput.focus();
    } else {
      searchResults.textContent = '';
    }
  }

  searchToggle.addEventListener('click', function() {
    setSearchOpen(searchPanel.hidden);
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !searchPanel.hidden) {
      setSearchOpen(false);
      searchToggle.focus();
    }
  });

  searchInput.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    const query = searchInput.value.trim();

    if (query.length < 2) {
      searchResults.textContent = '';
      return;
    }

    debounceTimer = setTimeout(function() {
      const body = new URLSearchParams({
        action: 'pmo_search',
        nonce: pmoTheme.nonce,
        query: query
      });

      fetch(pmoTheme.ajaxUrl, { method: 'POST', body: body })
        .then(res => res.json())
        .then(data => {
          searchResults.textContent = '';

          if (!data.success || !data.data.results.length) {
            const empty = document.createElement('p');
            empty.className = 'header-search-empty';
            empty.textContent = 'No results found.';
            searchResults.appendChild(empty);
            return;
          }

          const list = document.createElement('ul');
          data.data.results.forEach(item => {
            const li = document.createElement('li');
            const link = document.createElement('a');
            link.href = item.url;
            link.textContent = item.title;
            const type = document.createElement('span');
            type.className = 'header-search-type';
            type.textContent = item.type;
            li.appendChild(link);
            li.appendChild(type);
            list.appendChild(li);
          });
          searchResults.appendChild(list);
        })
        .catch(() => {
          searchResults.textContent = '';
        });
    }, 300);
  });
});
