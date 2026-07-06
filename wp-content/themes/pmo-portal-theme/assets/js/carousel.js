/**
 * PMO Carousel - Auto-play with fade animation
 *
 * Respects prefers-reduced-motion (no auto-play), keeps hidden slides
 * unfocusable, and scopes keyboard navigation to the carousel.
 */
document.addEventListener('DOMContentLoaded', function() {
	const carousel = document.querySelector('.hero-carousel');
	if (!carousel) return;

	const slides = carousel.querySelectorAll('.carousel-slide');
	const dots = carousel.querySelectorAll('.carousel-dot');
	const prevBtn = carousel.querySelector('.carousel-prev');
	const nextBtn = carousel.querySelector('.carousel-next');
	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (slides.length === 0) return;

	let currentSlide = 0;
	let autoPlayInterval;

	// Show carousel controls on desktop
	if (window.innerWidth > 768) {
		if (prevBtn) prevBtn.style.display = 'flex';
		if (nextBtn) nextBtn.style.display = 'flex';
	}

	function showSlide(index) {
		currentSlide = (index + slides.length) % slides.length;

		slides.forEach((slide, i) => {
			const isActive = i === currentSlide;
			slide.style.opacity = isActive ? '1' : '0';
			// Keep links in hidden slides out of the tab order / accessibility tree
			slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
			slide.querySelectorAll('a, button').forEach(el => {
				el.tabIndex = isActive ? 0 : -1;
			});
		});

		dots.forEach((dot, i) => {
			dot.style.background = i === currentSlide ? 'rgba(255, 255, 255, 0.9)' : 'rgba(255, 255, 255, 0.5)';
			dot.setAttribute('aria-current', i === currentSlide ? 'true' : 'false');
		});
	}

	function nextSlide() {
		showSlide(currentSlide + 1);
		resetAutoPlay();
	}

	function prevSlide() {
		showSlide(currentSlide - 1);
		resetAutoPlay();
	}

	function autoPlay() {
		if (prefersReducedMotion || slides.length < 2) return;
		autoPlayInterval = setInterval(() => {
			showSlide(currentSlide + 1);
		}, 6000);
	}

	function resetAutoPlay() {
		clearInterval(autoPlayInterval);
		autoPlay();
	}

	// Event listeners
	if (prevBtn) prevBtn.addEventListener('click', prevSlide);
	if (nextBtn) nextBtn.addEventListener('click', nextSlide);

	dots.forEach((dot, index) => {
		dot.addEventListener('click', () => {
			showSlide(index);
			resetAutoPlay();
		});
	});

	// Pause on hover
	carousel.addEventListener('mouseenter', () => {
		clearInterval(autoPlayInterval);
	});

	carousel.addEventListener('mouseleave', () => {
		autoPlay();
	});

	// Keyboard navigation — only when focus is inside the carousel, so
	// arrow keys elsewhere on the page are left alone
	carousel.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowLeft') prevSlide();
		if (e.key === 'ArrowRight') nextSlide();
	});

	// Initialize
	showSlide(0);
	autoPlay();
});
