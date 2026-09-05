import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const toggle = document.querySelector('[data-mobile-toggle]');
	const menu = document.querySelector('#mobile-menu');

	if (!toggle || !menu) return;

	toggle.addEventListener('click', () => {
		const isOpen = toggle.getAttribute('aria-expanded') === 'true';
		toggle.setAttribute('aria-expanded', String(!isOpen));
		menu.classList.toggle('hidden', isOpen);
		toggle.querySelector('[data-menu-open]')?.classList.toggle('hidden', !isOpen);
		toggle.querySelector('[data-menu-close]')?.classList.toggle('hidden', isOpen);
	});
});
