/* ADGON — Premium Clothing E-Commerce Interactions */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initNav();
    initCart();
    initCartItems();
    initScrollReveal();
    initWardrobeSteps();
    initMarquee();
    initSmoothScroll();
});

/* ── Theme Toggle ── */
function initTheme() {
    const toggle = document.querySelector('.theme-toggle');
    if (!toggle) return;

    const iconDark = toggle.querySelector('.theme-icon-dark');
    const iconLight = toggle.querySelector('.theme-icon-light');

    const updateIcons = () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        if (iconDark) iconDark.style.display = isDark ? 'none' : 'inline';
        if (iconLight) iconLight.style.display = isDark ? 'inline' : 'none';
    };

    updateIcons();

    toggle.addEventListener('click', () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        if (isDark) {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('adgon-theme', 'light');
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('adgon-theme', 'dark');
        }
        updateIcons();
    });
}

/* ── Navigation ── */
function initNav() {
    const nav = document.querySelector('.site-nav');
    const toggle = document.querySelector('.nav-toggle');
    const overlay = document.querySelector('.nav-overlay');
    const menu = document.querySelector('.nav-menu');
    const closeBtn = document.querySelector('.nav-close');

    if (!nav) return;

    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    });

    const openMenu = () => {
        menu?.classList.add('open');
        overlay?.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeMenu = () => {
        menu?.classList.remove('open');
        overlay?.classList.remove('open');
        document.body.style.overflow = '';
    };

    toggle?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    menu?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
}

/* ── Cart Drawer ── */
function initCart() {
    const cartBtn = document.querySelector('.cart-trigger');
    const cartDrawer = document.querySelector('.cart-drawer');
    const cartOverlay = document.querySelector('.cart-overlay');
    const cartClose = document.querySelector('.cart-close');

    const openCart = () => {
        cartDrawer?.classList.add('open');
        cartOverlay?.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeCart = () => {
        cartDrawer?.classList.remove('open');
        cartOverlay?.classList.remove('open');
        document.body.style.overflow = '';
    };

    cartBtn?.addEventListener('click', openCart);
    cartClose?.addEventListener('click', closeCart);
    cartOverlay?.addEventListener('click', closeCart);

    window.openCart = openCart;
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content;
}

function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = count;
    });
    const header = document.querySelector('.cart-header h3');
    if (header) header.textContent = `Shopping Cart (${count})`;
}

function updateCartTotal(subtotal) {
    const el = document.getElementById('cartTotal');
    if (el) el.textContent = `₹${Number(subtotal).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

/* ── Add to Cart ── */
window.addToCart = async function(productId, quantity = 1, size = null, btn = null) {
    try {
        const res = await fetch(window.ADGON_ROUTES.cartAdd, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId, quantity, size }),
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Could not add to cart');
            return;
        }

        updateCartCount(data.count);
        updateCartTotal(data.subtotal);

        if (btn) addToCartAnimate(btn);

        setTimeout(() => location.reload(), btn ? 1200 : 0);
    } catch (e) {
        alert('Something went wrong. Please try again.');
    }
};

window.addToCartAnimate = function(btn) {
    btn.classList.add('added');
    const original = btn.innerHTML;
    btn.innerHTML = '<span class="check-icon">✓</span> Added';
    btn.disabled = true;
    setTimeout(() => {
        btn.classList.remove('added');
        btn.innerHTML = original;
        btn.disabled = false;
    }, 2000);
};

/* ── Cart Item Controls ── */
function initCartItems() {
    document.querySelectorAll('.cart-item').forEach(item => {
        const productId = item.dataset.productId;
        const size = item.dataset.size || null;

        item.querySelector('.qty-minus')?.addEventListener('click', () => {
            const qty = parseInt(item.querySelector('.qty-value').textContent);
            updateCartItem(productId, qty - 1, size);
        });

        item.querySelector('.qty-plus')?.addEventListener('click', () => {
            const qty = parseInt(item.querySelector('.qty-value').textContent);
            updateCartItem(productId, qty + 1, size);
        });

        item.querySelector('.cart-item-remove')?.addEventListener('click', () => {
            removeCartItem(productId, size);
        });
    });
}

async function updateCartItem(productId, quantity, size) {
    try {
        const res = await fetch(`${window.ADGON_ROUTES.cartUpdate}/${productId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ quantity, size }),
        });

        const data = await res.json();
        if (!res.ok) {
            alert(data.message || 'Could not update cart');
            return;
        }

        location.reload();
    } catch (e) {
        alert('Something went wrong.');
    }
}

async function removeCartItem(productId, size) {
    try {
        const res = await fetch(`${window.ADGON_ROUTES.cartRemove}/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ size }),
        });

        location.reload();
    } catch (e) {
        alert('Something went wrong.');
    }
}

/* ── Scroll Reveal ── */
function initScrollReveal() {
    const els = document.querySelectorAll('.reveal');
    if (!els.length) return;

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    els.forEach(el => observer.observe(el));
}

/* ── Wardrobe Steps ── */
function initWardrobeSteps() {
    const steps = document.querySelectorAll('.wardrobe-step');
    const indicators = document.querySelectorAll('.step-indicator');
    if (!steps.length) return;

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const idx = entry.target.dataset.step;
                    indicators.forEach(ind => {
                        ind.classList.toggle('active', ind.dataset.step === idx);
                    });
                    steps.forEach(s => s.classList.remove('active'));
                    entry.target.classList.add('active');
                }
            });
        },
        { threshold: 0.5 }
    );

    steps.forEach(step => observer.observe(step));
}

/* ── Marquee ── */
function initMarquee() {
    const track = document.querySelector('.marquee-track');
    if (!track) return;
    const clone = track.innerHTML;
    track.innerHTML += clone;
}

/* ── Smooth Scroll ── */
function initSmoothScroll() {
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            const href = anchor.getAttribute('href');
            const hash = href.includes('#') ? href.split('#')[1] : null;
            if (!hash) return;
            const target = document.getElementById(hash);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}
