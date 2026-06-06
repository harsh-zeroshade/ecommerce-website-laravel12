/* ADGON — Premium Clothing E-Commerce Interactions */

document.addEventListener('DOMContentLoaded', () => {
    // Hide customer loading overlay
    const loadingOverlay = document.getElementById('customerLoadingOverlay');
    if (loadingOverlay) {
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
            setTimeout(() => loadingOverlay.remove(), 400);
        }, 300);
    }
    
    initTheme();
    initNav();
    initCart();
    initCartItems();
    initScrollReveal();
    initWardrobeSteps();
    initMarquee();
    initSmoothScroll();
    initShopFilters();
    initProductSliders();
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

/* ── Toast Notifications ── */
function ensureToastContainer() {
    let c = document.getElementById('adgonToastContainer');
    if (!c) {
        c = document.createElement('div');
        c.id = 'adgonToastContainer';
        c.className = 'adgon-toast-container';
        document.body.appendChild(c);
    }
    return c;
}

window.showToast = function(message, type = 'info', duration = 2400) {
    const container = ensureToastContainer();
    const toast = document.createElement('div');
    toast.className = `adgon-toast adgon-toast--${type}`;

    const iconMap = {
        success: 'bi-check-circle-fill',
        error: 'bi-exclamation-circle-fill',
        info: 'bi-info-circle-fill',
    };

    toast.innerHTML = `<i class="bi ${iconMap[type] || iconMap.info}"></i><span>${message}</span>`;
    container.appendChild(toast);

    // Trigger enter animation
    requestAnimationFrame(() => toast.classList.add('adgon-toast--show'));

    setTimeout(() => {
        toast.classList.remove('adgon-toast--show');
        toast.classList.add('adgon-toast--hide');
        setTimeout(() => toast.remove(), 350);
    }, duration);
};

/* ── Wishlist Helpers ── */
window.updateWishlistCount = function(count) {
    document.querySelectorAll('.wishlist-count').forEach(el => {
        el.textContent = count;
        el.classList.toggle('wishlist-count--hidden', count === 0);
    });
    // Swap the heart icon between fill/outline in the topbar
    document.querySelectorAll('.wishlist-link > i').forEach(icon => {
        if (count > 0) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }
    });
};

function setWishlistBtnState(btn, added) {
    if (!btn) return;
    btn.classList.toggle('is-wishlisted', added);
    btn.setAttribute('title', added ? 'Remove from Wishlist' : 'Add to Wishlist');

    // Update the heart icon (works for product-tile and product-detail)
    const icon = btn.querySelector('i');
    if (icon) {
        if (added) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }
    }

    // Update label text on the big detail-page button
    const label = btn.querySelector('.wishlist-btn-label');
    if (label) {
        label.textContent = added ? 'In Wishlist' : 'Add to Wishlist';
    }
}

function syncAllWishlistBtnsForProduct(productId, added) {
    document.querySelectorAll(`[data-wishlist-btn][data-product-id="${productId}"]`).forEach(b => {
        setWishlistBtnState(b, added);
    });
}

/* ── Toggle Wishlist (heart button) ── */
window.toggleWishlist = async function(productId, btn = null) {
    if (!window.ADGON_ROUTES?.wishlistToggle) return;

    // Optimistic UI — flip state immediately for snappy feedback
    const wasAdded = btn?.classList.contains('is-wishlisted');
    const optimisticAdded = !wasAdded;
    if (btn) {
        setWishlistBtnState(btn, optimisticAdded);
        // Burst animation
        btn.classList.add('wishlist-burst');
        setTimeout(() => btn.classList.remove('wishlist-burst'), 600);
    }

    try {
        const res = await fetch(window.ADGON_ROUTES.wishlistToggle, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId }),
        });

        // Not logged in → 401 with redirect URL
        if (res.status === 401) {
            const data = await res.json().catch(() => ({}));
            showToast(data.message || 'Please log in to use your wishlist.', 'info', 3200);
            // Revert optimistic state
            if (btn) setWishlistBtnState(btn, !!wasAdded);
            // Small delay so the toast is visible before redirect
            setTimeout(() => {
                const url = data.redirect || window.ADGON_ROUTES.loginUrl;
                window.location.href = url + '?redirect=' + encodeURIComponent(window.location.pathname);
            }, 600);
            return;
        }

        const data = await res.json();
        if (!res.ok) {
            // Revert on error
            if (btn) setWishlistBtnState(btn, !!wasAdded);
            showToast(data.message || 'Could not update wishlist.', 'error');
            return;
        }

        // Sync all matching buttons on the page to the canonical state
        syncAllWishlistBtnsForProduct(productId, data.added);
        updateWishlistCount(data.count);

        showToast(data.message, data.added ? 'success' : 'info', 1800);
    } catch (e) {
        if (btn) setWishlistBtnState(btn, !!wasAdded);
        showToast('Something went wrong. Please try again.', 'error');
    }
};

/* ── Legacy alias kept for backwards compat with any older markup ── */
window.addToWishlist = window.toggleWishlist;

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

/* ── Shop Filters ── */
function initShopFilters() {
    const sidebar = document.getElementById('shopSidebar');
    const toggle = document.querySelector('.shop-filter-toggle');
    const overlay = document.querySelector('.shop-filter-overlay');
    const closeBtn = document.querySelector('.shop-sidebar-close');
    const form = document.getElementById('filterForm');

    if (!sidebar) return;

    const open = () => {
        sidebar.classList.add('open');
        overlay?.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        sidebar.classList.remove('open');
        overlay?.classList.remove('open');
        document.body.style.overflow = '';
    };

    toggle?.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    overlay?.addEventListener('click', close);

    // Toggle active states on category & sort selection
    form?.querySelectorAll('.filter-category-item input, .filter-sort-pill input').forEach(input => {
        input.addEventListener('change', () => {
            const group = input.closest('.filter-category-list, .filter-sort-options');
            group?.querySelectorAll('.filter-category-item, .filter-sort-pill').forEach(el => {
                el.classList.remove('active');
            });
            input.closest('.filter-category-item, .filter-sort-pill')?.classList.add('active');
        });
    });
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

/* ── Product Sliders ── */
function initProductSliders() {
    document.querySelectorAll('.product-slider').forEach(el => {
        const swiperEl = el.querySelector('.swiper');
        if (!swiperEl) return;

        new Swiper(swiperEl, {
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                prevEl: el.querySelector('.swiper-button-prev'),
                nextEl: el.querySelector('.swiper-button-next'),
            },
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    });
}
