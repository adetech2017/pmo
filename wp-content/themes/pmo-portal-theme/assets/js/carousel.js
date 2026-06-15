/**
 * PMO Carousel - Auto-play with fade animation
 */
document.addEventListener('DOMContentLoaded', function() {
	const carousel = document.querySelector('.hero-carousel');
	if (!carousel) return;

	const slides = document.querySelectorAll('.carousel-slide');
	const dots = document.querySelectorAll('.carousel-dot');
	const prevBtn = document.querySelector('.carousel-prev');
	const nextBtn = document.querySelector('.carousel-next');

	if (slides.length === 0) return;

	let currentSlide = 0;
	let autoPlayInterval;

	// Show carousel controls on desktop
	if (window.innerWidth > 768) {
		if (prevBtn) prevBtn.style.display = 'flex';
		if (nextBtn) nextBtn.style.display = 'flex';
	}

	function showSlide(index) {
		// Hide all slides
		slides.forEach(slide => {
			slide.style.opacity = '0';
		});

		// Remove active class from all dots
		dots.forEach(dot => {
			dot.style.background = 'rgba(255, 255, 255, 0.5)';
		});

		// Show current slide
		currentSlide = (index + slides.length) % slides.length;
		slides[currentSlide].style.opacity = '1';
		if (dots[currentSlide]) {
			dots[currentSlide].style.background = 'rgba(255, 255, 255, 0.9)';
		}
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
		autoPlayInterval = setInterval(() => {
			showSlide(currentSlide + 1);
		}, 6000); // 6 seconds
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

	// Keyboard navigation
	document.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowLeft') prevSlide();
		if (e.key === 'ArrowRight') nextSlide();
	});

	// Initialize
	showSlide(0);
	autoPlay();
});
