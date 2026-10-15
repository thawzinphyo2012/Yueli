import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

function bootIcons() {
    createIcons({ icons });
}

function bootReveals() {
    const nodes = document.querySelectorAll(
        '.reveal, .fade-up, .fade-left, .fade-right, .scale-in, .clip-up'
    );

    if (! nodes.length) {
        return;
    }

    if (! ('IntersectionObserver' in window)) {
        nodes.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -6% 0px' }
    );

    nodes.forEach((el) => observer.observe(el));
}

function bootParallax() {
    const layers = document.querySelectorAll('[data-parallax]');
    if (! layers.length) {
        return;
    }

    const onScroll = () => {
        const y = window.scrollY;
        layers.forEach((el) => {
            const speed = Number(el.getAttribute('data-parallax') || 0.12);
            el.style.transform = `translate3d(0, ${y * speed}px, 0)`;
        });
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
    bootIcons();
    bootReveals();
    bootParallax();
});

document.addEventListener('alpine:initialized', bootIcons);
