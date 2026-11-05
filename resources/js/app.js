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
                && ! child.classList.contains('clip-up')
                && ! child.classList.contains('bloom-in')
                && ! child.classList.contains('mask-wipe')) {
                child.classList.add('reveal');
            }
        });
    });

    document.querySelectorAll('.text-rise:not([data-split])').forEach((el) => {
        const text = el.textContent.trim();
        el.setAttribute('data-split', '1');
        el.setAttribute('aria-label', text);
        el.innerHTML = '';
        [...text].forEach((char, index) => {
            const span = document.createElement('span');
            span.textContent = char === ' ' ? '\u00a0' : char;
            span.style.animationDelay = `${0.04 + index * 0.035}s`;
            el.appendChild(span);
        });
    });

    const all = document.querySelectorAll(
        '.reveal, .fade-up, .fade-left, .fade-right, .scale-in, .clip-up, .bloom-in, .mask-wipe, .text-rise, .quote-frame, .section-label'
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

function bootMagneticButtons() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }
    if (window.matchMedia('(pointer: coarse)').matches) {
        return;
    }

    document.querySelectorAll('.btn-rose, .btn-outline, .btn-primary').forEach((btn) => {
        btn.classList.add('btn-shine');
        btn.addEventListener('pointermove', (event) => {
            const rect = btn.getBoundingClientRect();
            const x = event.clientX - rect.left - rect.width / 2;
            const y = event.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.12}px, ${y * 0.18}px)`;
        });
        btn.addEventListener('pointerleave', () => {
            btn.style.transform = '';
        });
    });
}

function bootTiltCards() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }
    if (window.matchMedia('(pointer: coarse)').matches) {
        return;
    }

    document.querySelectorAll('.product-box, .lift-card, .img-card').forEach((card) => {
        card.classList.add('tilt-card');
        card.addEventListener('pointermove', (event) => {
            const rect = card.getBoundingClientRect();
            const px = (event.clientX - rect.left) / rect.width;
            const py = (event.clientY - rect.top) / rect.height;
            const rotateY = (px - 0.5) * 6;
            const rotateX = (0.5 - py) * 6;
            card.style.transform = `perspective(900px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
        });
        card.addEventListener('pointerleave', () => {
            card.style.transform = '';
        });
    });
}

function bootHeaderScroll() {
    const header = document.querySelector('.site-header');
    if (! header) {
        return;
    }

    const update = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
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
    bootMagneticButtons();
    bootTiltCards();
    bootHeaderScroll();
});

document.addEventListener('alpine:initialized', bootIcons);
