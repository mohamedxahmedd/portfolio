import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

window.Alpine = Alpine;
window.Swiper = Swiper;

Alpine.plugin(collapse);
Alpine.plugin(intersect);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.addEventListener('alpine:init', () => {
    /* ════════════════════════════════════════════
       PRELOADER + page enter
       ════════════════════════════════════════════ */
    Alpine.data('preloader', () => ({
        loaded: false,
        init() {
            const finish = () => {
                this.loaded = true;
                this.$el.classList.add('is-loaded');
                document.body.classList.add('page-ready');
                setTimeout(() => this.$el.remove(), 700);
            };
            if (document.readyState === 'complete') {
                setTimeout(finish, 350);
            } else {
                window.addEventListener('load', () => setTimeout(finish, 350));
            }
        },
    }));

    /* ════════════════════════════════════════════
       SCROLL PROGRESS BAR
       ════════════════════════════════════════════ */
    Alpine.data('scrollProgress', () => ({
        init() {
            const update = () => {
                const h = document.documentElement;
                const scrolled = h.scrollTop / (h.scrollHeight - h.clientHeight);
                this.$el.style.transform = `scaleX(${Math.min(Math.max(scrolled, 0), 1)})`;
            };
            update();
            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update, { passive: true });
        },
    }));

    /* ════════════════════════════════════════════
       CUSTOM CURSOR (ring + dot + optional text label)
       ════════════════════════════════════════════ */
    Alpine.data('cursor', () => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) {
                this.$el.style.display = 'none';
                return;
            }
            const ring = this.$el.querySelector('.cursor-ring');
            const dot = this.$el.querySelector('.cursor-dot');
            let mx = 0, my = 0, rx = 0, ry = 0, dx = 0, dy = 0;

            window.addEventListener('mousemove', (e) => { mx = e.clientX; my = e.clientY; });
            window.addEventListener('mouseleave', () => { ring.style.opacity = '0'; dot.style.opacity = '0'; });
            window.addEventListener('mouseenter',  () => { ring.style.opacity = '1'; dot.style.opacity = '1'; });

            const tick = () => {
                rx += (mx - rx) * 0.18;
                ry += (my - ry) * 0.18;
                dx += (mx - dx) * 0.55;
                dy += (my - dy) * 0.55;
                ring.style.transform = `translate3d(${rx - 16}px, ${ry - 16}px, 0)`;
                dot.style.transform  = `translate3d(${dx - 3}px, ${dy - 3}px, 0)`;
                requestAnimationFrame(tick);
            };
            tick();

            const resetRing = () => {
                ring.style.width = '32px';
                ring.style.height = '32px';
                ring.style.backgroundColor = 'transparent';
                ring.classList.remove('has-text');
                ring.removeAttribute('data-text');
            };

            const grow = (el) => {
                el.addEventListener('mouseenter', () => {
                    const text = el.dataset.cursorText;
                    if (text) {
                        ring.style.width = '74px';
                        ring.style.height = '74px';
                        ring.style.backgroundColor = 'var(--color-brand-500)';
                        ring.classList.add('has-text');
                        ring.setAttribute('data-text', text);
                    } else {
                        ring.style.width = '56px';
                        ring.style.height = '56px';
                        ring.style.backgroundColor = 'rgba(255,1,79,0.18)';
                    }
                });
                el.addEventListener('mouseleave', resetRing);
            };
            const refresh = () => {
                document.querySelectorAll('a, button, [role="button"], input, textarea, select, label, .tilt, [data-cursor-text]')
                    .forEach((el) => {
                        if (el.dataset.cursorBound) return;
                        el.dataset.cursorBound = '1';
                        grow(el);
                    });
            };
            refresh();
            // Re-bind when Livewire/Alpine swap DOM
            new MutationObserver(refresh).observe(document.body, { childList: true, subtree: true });
        },
    }));

    /* ════════════════════════════════════════════
       MOUSE PARALLAX — child elements with data-parallax="0.05"
       move based on cursor position within the parent (3D depth).
       ════════════════════════════════════════════ */
    Alpine.data('parallax', () => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) return;
            const targets = Array.from(this.$el.querySelectorAll('[data-parallax]')).map((el) => ({
                el,
                depth: parseFloat(el.dataset.parallax) || 0.05,
                cx: 0, cy: 0,
            }));
            if (!targets.length) return;
            let mx = 0, my = 0, tx = 0, ty = 0;
            const onMove = (e) => {
                const r = this.$el.getBoundingClientRect();
                mx = (e.clientX - r.left - r.width / 2);
                my = (e.clientY - r.top - r.height / 2);
            };
            const onLeave = () => { mx = 0; my = 0; };
            this.$el.addEventListener('mousemove', onMove);
            this.$el.addEventListener('mouseleave', onLeave);
            const tick = () => {
                tx += (mx - tx) * 0.08;
                ty += (my - ty) * 0.08;
                targets.forEach((t) => {
                    t.cx += (tx * t.depth - t.cx) * 0.18;
                    t.cy += (ty * t.depth - t.cy) * 0.18;
                    t.el.style.transform = `translate3d(${t.cx}px, ${t.cy}px, 0)`;
                });
                requestAnimationFrame(tick);
            };
            tick();
        },
    }));

    /* ════════════════════════════════════════════
       LETTER REVEAL — each char animates in with stagger
       ════════════════════════════════════════════ */
    Alpine.data('letterReveal', (delay = 0) => ({
        init() {
            const text = this.$el.textContent.trim();
            this.$el.setAttribute('aria-label', text);
            if (prefersReducedMotion) return;
            const chars = [...text].map((ch, i) => {
                const c = ch === ' ' ? '&nbsp;' : ch;
                return `<span class="letter-fx" aria-hidden="true" style="animation-delay:${(i * 45 + delay)}ms">${c}</span>`;
            }).join('');
            this.$el.innerHTML = chars;
            this.$el.classList.add('letter-reveal');
        },
    }));

    /* ════════════════════════════════════════════
       WORD REVEAL — split text into words, fade+slide on intersect
       ════════════════════════════════════════════ */
    Alpine.data('wordReveal', () => ({
        init() {
            const text = this.$el.innerHTML;
            this.$el.setAttribute('aria-label', this.$el.textContent.trim());
            if (prefersReducedMotion) return;
            // Split outer text nodes by space into wrapped words.
            // Preserve inline HTML (like <span> for gradient text) by walking nodes.
            const wrap = (node) => {
                if (node.nodeType === 3) {
                    const frag = document.createDocumentFragment();
                    node.nodeValue.split(/(\s+)/).forEach((part) => {
                        if (part.match(/^\s+$/)) {
                            frag.appendChild(document.createTextNode(part));
                        } else if (part.length) {
                            const span = document.createElement('span');
                            span.className = 'word-fx';
                            span.setAttribute('aria-hidden', 'true');
                            span.textContent = part;
                            frag.appendChild(span);
                        }
                    });
                    node.parentNode.replaceChild(frag, node);
                } else if (node.nodeType === 1 && node.childNodes.length) {
                    // Wrap inline elements (e.g. <span class="text-gradient-brand">word</span>) as a single word-fx
                    if (node.tagName === 'SPAN' && !node.querySelector('*')) {
                        const span = document.createElement('span');
                        span.className = 'word-fx';
                        span.setAttribute('aria-hidden', 'true');
                        span.innerHTML = node.outerHTML;
                        node.replaceWith(span);
                    } else {
                        Array.from(node.childNodes).forEach(wrap);
                    }
                }
            };
            Array.from(this.$el.childNodes).forEach(wrap);
            this.$el.classList.add('word-reveal');
            // Stagger via per-element delay
            this.$el.querySelectorAll('.word-fx').forEach((el, i) => {
                el.style.animationDelay = `${i * 60}ms`;
            });
        },
    }));

    /* ════════════════════════════════════════════
       (Reveal observer is now a global vanilla-JS setup
        below, independent of Alpine — works even on
        elements with no x-data ancestor.)
       ════════════════════════════════════════════ */

    /* ════════════════════════════════════════════
       NUMBER COUNTER (used in stats)
       ════════════════════════════════════════════ */
    Alpine.data('counter', (target = 0, duration = 1800) => ({
        value: 0,
        target: Number(target),
        run() {
            if (prefersReducedMotion) { this.value = this.target; return; }
            const start = performance.now();
            const ease = (t) => 1 - Math.pow(1 - t, 3);
            const tick = (now) => {
                const t = Math.min((now - start) / duration, 1);
                this.value = Math.floor(ease(t) * this.target);
                if (t < 1) requestAnimationFrame(tick);
                else this.value = this.target;
            };
            requestAnimationFrame(tick);
        },
    }));

    /* ════════════════════════════════════════════
       TYPEWRITER — cycles through phrases
       ════════════════════════════════════════════ */
    Alpine.data('typewriter', (phrases = [], typeSpeed = 70, deleteSpeed = 35, holdMs = 1600) => ({
        phrases,
        text: '',
        i: 0,
        deleting: false,
        init() {
            if (prefersReducedMotion || !this.phrases.length) {
                this.text = this.phrases[0] || '';
                return;
            }
            this.tick();
        },
        tick() {
            const current = this.phrases[this.i % this.phrases.length];
            if (!this.deleting) {
                this.text = current.slice(0, this.text.length + 1);
                if (this.text === current) {
                    this.deleting = true;
                    setTimeout(() => this.tick(), holdMs);
                    return;
                }
                setTimeout(() => this.tick(), typeSpeed + Math.random() * 50);
            } else {
                this.text = current.slice(0, this.text.length - 1);
                if (this.text === '') {
                    this.deleting = false;
                    this.i = (this.i + 1) % this.phrases.length;
                }
                setTimeout(() => this.tick(), deleteSpeed);
            }
        },
    }));

    /* ════════════════════════════════════════════
       3D TILT (used on project cards)
       ════════════════════════════════════════════ */
    Alpine.data('tilt', (max = 8) => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) return;
            const el = this.$el;
            const onMove = (e) => {
                const r = el.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width  - 0.5;
                const y = (e.clientY - r.top)  / r.height - 0.5;
                el.style.transform = `perspective(900px) rotateX(${-y * max}deg) rotateY(${x * max}deg) translateZ(0)`;
            };
            const onLeave = () => { el.style.transform = ''; };
            el.addEventListener('mousemove', onMove);
            el.addEventListener('mouseleave', onLeave);
        },
    }));

    /* ════════════════════════════════════════════
       MAGNETIC BUTTON — pulls toward cursor
       ════════════════════════════════════════════ */
    Alpine.data('magnetic', (strength = 0.25) => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) return;
            const el = this.$el;
            const onMove = (e) => {
                const r = el.getBoundingClientRect();
                const x = (e.clientX - r.left - r.width / 2) * strength;
                const y = (e.clientY - r.top - r.height / 2) * strength;
                el.style.transform = `translate3d(${x}px, ${y}px, 0)`;
            };
            const onLeave = () => { el.style.transform = ''; };
            el.addEventListener('mousemove', onMove);
            el.addEventListener('mouseleave', onLeave);
        },
    }));

    /* ════════════════════════════════════════════
       TESTIMONIALS — Swiper
       ════════════════════════════════════════════ */
    Alpine.data('testimonials', () => ({
        init() {
            new Swiper(this.$refs.swiper, {
                modules: [Navigation, Pagination, Autoplay],
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                autoplay: { delay: 6000, disableOnInteraction: false },
                pagination: { el: this.$refs.pagination, clickable: true },
                navigation: { prevEl: this.$refs.prev, nextEl: this.$refs.next },
                breakpoints: {
                    768:  { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
                speed: 700,
            });
        },
    }));

    /* ════════════════════════════════════════════
       Image blur-up loader (fail-safe: also un-blurs on 404)
       ════════════════════════════════════════════ */
    Alpine.data('imgLoad', () => ({
        init() {
            const img = this.$el;
            const ready = () => img.classList.add('is-loaded');
            if (img.complete) { ready(); return; }
            img.addEventListener('load',  ready, { once: true });
            img.addEventListener('error', ready, { once: true });
            // Safety net: force-unblur after 1.5s no matter what
            setTimeout(ready, 1500);
        },
    }));

    /* ════════════════════════════════════════════
       SPOTLIGHT — pink radial light follows cursor inside element
       (massive premium feel on card sections)
       ════════════════════════════════════════════ */
    Alpine.data('spotlight', () => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) return;
            this.$el.classList.add('spotlight');
            this.$el.addEventListener('mousemove', (e) => {
                const r = this.$el.getBoundingClientRect();
                this.$el.style.setProperty('--spot-x', (e.clientX - r.left) + 'px');
                this.$el.style.setProperty('--spot-y', (e.clientY - r.top) + 'px');
            });
        },
    }));

    /* ════════════════════════════════════════════
       CARD FX — combined tilt + spotlight on a single element
       (use as `x-data="cardFx"` or `x-data="cardFx(8)"`)
       ════════════════════════════════════════════ */
    Alpine.data('cardFx', (max = 6) => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) return;
            const el = this.$el;
            el.classList.add('spotlight');
            const onMove = (e) => {
                const r = el.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                el.style.transform = `perspective(900px) rotateX(${(-y * max).toFixed(2)}deg) rotateY(${(x * max).toFixed(2)}deg) translateZ(0)`;
                el.style.setProperty('--spot-x', (e.clientX - r.left) + 'px');
                el.style.setProperty('--spot-y', (e.clientY - r.top) + 'px');
            };
            const onLeave = () => { el.style.transform = ''; };
            el.addEventListener('mousemove', onMove);
            el.addEventListener('mouseleave', onLeave);
        },
    }));

    /* ════════════════════════════════════════════
       MARQUEE — speeds up briefly on scroll
       ════════════════════════════════════════════ */
    Alpine.data('marqueeAccel', (baseSec = 35) => ({
        speed: baseSec,
        target: baseSec,
        init() {
            if (prefersReducedMotion) return;
            const track = this.$el.querySelector('.marquee-track');
            if (!track) return;
            let lastY = window.scrollY;
            let lastT = performance.now();
            window.addEventListener('scroll', () => {
                const now = performance.now();
                const dy = Math.abs(window.scrollY - lastY);
                const dt = Math.max(now - lastT, 1);
                const v = dy / dt; // px / ms
                this.target = Math.max(8, baseSec - v * 22);
                lastY = window.scrollY;
                lastT = now;
            }, { passive: true });
            const decay = () => {
                this.speed += (this.target - this.speed) * 0.06;
                this.target += (baseSec - this.target) * 0.04;
                track.style.animationDuration = this.speed.toFixed(2) + 's';
                requestAnimationFrame(decay);
            };
            decay();
        },
    }));

    /* ════════════════════════════════════════════
       CURSOR TRAIL — small dots fade out behind the cursor
       ════════════════════════════════════════════ */
    Alpine.data('cursorTrail', () => ({
        init() {
            if (prefersReducedMotion || !window.matchMedia('(pointer: fine)').matches) {
                this.$el.style.display = 'none';
                return;
            }
            const layer = this.$el;
            let lastX = 0, lastY = 0, lastTime = 0;
            window.addEventListener('mousemove', (e) => {
                const t = performance.now();
                if (t - lastTime < 28) return; // throttle to ~36fps
                const dx = e.clientX - lastX;
                const dy = e.clientY - lastY;
                if (Math.hypot(dx, dy) < 8) return;
                lastX = e.clientX;
                lastY = e.clientY;
                lastTime = t;
                const dot = document.createElement('span');
                dot.className = 'trail-dot';
                dot.style.left = e.clientX + 'px';
                dot.style.top = e.clientY + 'px';
                layer.appendChild(dot);
                setTimeout(() => dot.remove(), 700);
            });
        },
    }));

    /* ════════════════════════════════════════════
       SCROLL PARALLAX — element drifts as page scrolls
       (use sparingly on background orbs in mid-page sections)
       ════════════════════════════════════════════ */
    Alpine.data('scrollParallax', (speed = 0.3) => ({
        init() {
            if (prefersReducedMotion) return;
            const el = this.$el;
            let raf;
            const update = () => {
                const r = el.getBoundingClientRect();
                const offset = (window.innerHeight / 2) - (r.top + r.height / 2);
                el.style.transform = `translate3d(0, ${(offset * speed).toFixed(1)}px, 0)`;
            };
            window.addEventListener('scroll', () => {
                if (raf) return;
                raf = requestAnimationFrame(() => { update(); raf = null; });
            }, { passive: true });
            update();
        },
    }));
});

Alpine.start();

/* ════════════════════════════════════════════════════════════════
   GLOBAL SCROLL-REVEAL OBSERVER (vanilla, framework-independent)

   Targets every element with `.reveal` or `.stagger` class and adds
   `.is-visible` once it scrolls into view. Runs regardless of
   Alpine — so reveals work even on elements outside any x-data scope.
   ════════════════════════════════════════════════════════════════ */
function bootRevealObserver() {
    const targets = document.querySelectorAll('.reveal:not(.is-visible), .stagger:not(.is-visible)');
    if (!targets.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    targets.forEach((el) => io.observe(el));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootRevealObserver);
} else {
    bootRevealObserver();
}

// Re-scan after every load + Livewire navigation so dynamic DOM also reveals.
window.addEventListener('load', bootRevealObserver);
document.addEventListener('livewire:navigated', bootRevealObserver);

/* SAFETY NET — if anything is still hidden 2.5 s after page load
   (e.g. observer mis-fired, layout shift), force-reveal it so users
   never see a blank section. */
window.addEventListener('load', () => {
    setTimeout(() => {
        document.querySelectorAll('.reveal:not(.is-visible), .stagger:not(.is-visible)')
            .forEach((el) => el.classList.add('is-visible'));
    }, 2500);
});
