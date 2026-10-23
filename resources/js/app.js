import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

function bootIcons() {
    createIcons({ icons });
}

function bootReveals() {
    document.querySelectorAll('.stagger-children').forEach((parent) => {
        Array.from(parent.children).forEach((child, index) => {
            child.style.setProperty('--stagger-i', String(index));
            if (! child.classList.contains('reveal')
                && ! child.classList.contains('fade-up')
                && ! child.classList.contains('scale-in')
                && ! child.classList.contains('clip-up')) {
                child.classList.add('reveal');
            }
        });
    });

    const all = document.querySelectorAll(
        '.reveal, .fade-up, .fade-left, .fade-right, .scale-in, .clip-up'
    );

    if (! all.length) {
        return;
    }

    if (! ('IntersectionObserver' in window)) {
        all.forEach((el) => el.classList.add('is-visible'));
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

    all.forEach((el) => observer.observe(el));
}

function bootParallax() {
    const layers = document.querySelectorAll('[data-parallax]');
    if (! layers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let ticking = false;
    const onScroll = () => {
        if (ticking) {
            return;
        }
        ticking = true;
        requestAnimationFrame(() => {
            const y = window.scrollY;
            layers.forEach((el) => {
                const speed = Number(el.getAttribute('data-parallax') || 0.12);
                el.style.transform = `translate3d(0, ${y * speed}px, 0)`;
            });
            ticking = false;
        });
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function bootScrollProgress() {
    const bar = document.querySelector('[data-scroll-progress]');
    if (! bar || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const update = () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const pct = max > 0 ? (window.scrollY / max) * 100 : 0;
        bar.style.width = `${Math.min(100, Math.max(0, pct))}%`;
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
    bootIcons();
    bootReveals();
    bootParallax();
    bootScrollProgress();
});

document.addEventListener('alpine:initialized', bootIcons);
