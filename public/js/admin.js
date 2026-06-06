/* ADGON Admin — Sidebar toggle, theme & responsive */

document.addEventListener('DOMContentLoaded', () => {
    // Hide global loading overlay
    const loadingOverlay = document.getElementById('globalLoadingOverlay');
    if (loadingOverlay) {
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
            setTimeout(() => loadingOverlay.remove(), 400);
        }, 300);
    }
    
    // Initialize reveal animations
    initRevealAnimations();
    
    initAdminTheme();

    const wrapper = document.querySelector('.admin-wrapper');
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.querySelector('.admin-sidebar-toggle');
    const overlay = document.querySelector('.admin-sidebar-overlay');
    const closeBtn = document.querySelector('.admin-sidebar-close');

    if (!wrapper || !sidebar || !toggle) {
        initDataTables();
        return;
    }

    const MOBILE_BP = 1024;
    const STORAGE_KEY = 'adgon-admin-sidebar-collapsed';

    const isMobile = () => window.innerWidth <= MOBILE_BP;

    const syncHamburger = () => {
        const active = wrapper.classList.contains('sidebar-open')
            || (!isMobile() && !wrapper.classList.contains('sidebar-collapsed'));
        toggle.classList.toggle('is-active', active);
    };

    const setCollapsed = (collapsed) => {
        wrapper.classList.toggle('sidebar-collapsed', collapsed);
        toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        if (!isMobile()) {
            localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
        }
        syncHamburger();
    };

    const openMobile = () => {
        wrapper.classList.add('sidebar-open');
        document.body.style.overflow = 'hidden';
        toggle.setAttribute('aria-expanded', 'true');
        syncHamburger();
    };

    const closeMobile = () => {
        wrapper.classList.remove('sidebar-open');
        document.body.style.overflow = '';
        toggle.setAttribute('aria-expanded', 'false');
        syncHamburger();
    };

    const initState = () => {
        if (isMobile()) {
            wrapper.classList.remove('sidebar-collapsed');
            closeMobile();
        } else {
            wrapper.classList.remove('sidebar-open');
            document.body.style.overflow = '';
            const collapsed = localStorage.getItem(STORAGE_KEY) === '1';
            setCollapsed(collapsed);
        }
        syncHamburger();
    };

    toggle.addEventListener('click', () => {
        if (isMobile()) {
            wrapper.classList.contains('sidebar-open') ? closeMobile() : openMobile();
        } else {
            setCollapsed(!wrapper.classList.contains('sidebar-collapsed'));
        }
    });

    overlay?.addEventListener('click', closeMobile);
    closeBtn?.addEventListener('click', closeMobile);

    sidebar.querySelectorAll('.admin-nav a, .admin-sidebar-footer a').forEach(link => {
        link.addEventListener('click', () => {
            if (isMobile()) closeMobile();
        });
    });

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            initState();
            syncHamburger();
        }, 150);
    });

    initState();

    initDataTables();
});

/* ── Theme Toggle (Admin) ── */
function initAdminTheme() {
    const toggle = document.querySelector('.admin-theme-toggle');
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
            localStorage.setItem('adgon-admin-theme', 'light');
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('adgon-admin-theme', 'dark');
        }
        updateIcons();
    });
}

/* ── DataTables ── */
function initDataTables() {
    if (typeof window.jQuery === 'undefined' || typeof jQuery.fn.DataTable !== 'function') {
        return;
    }

    const $ = window.jQuery;

    const baseConfig = {
        pageLength: 15,
        lengthChange: false,
        searching: true,
        info: true,
        ordering: true,
        autoWidth: false,
        language: {
            search: 'Filter:',
            searchPlaceholder: 'Type to search...',
            paginate: {
                previous: 'Prev',
                next: 'Next',
            },
            emptyTable: 'No records found',
        },
    };

    $('.datatable-dashboard').DataTable($.extend({}, baseConfig, { pageLength: 5 }));
    $('.datatable-list').DataTable(baseConfig);
    $('.datatable-detail').DataTable($.extend({}, baseConfig, { pageLength: 5, searching: false, info: false, lengthChange: false }));
}

/* ── Modern Form Enhancements ── */
function initAdminForms() {
    // 1) Live image previews for the new file-field partial
    document.querySelectorAll('[data-file-input]').forEach((input) => {
        const drop = input.closest('[data-file-drop]');
        const preview = drop?.parentElement.querySelector('[data-file-preview]');
        if (!drop || !preview) return;

        const renderFiles = (files) => {
            // Clear all generated previews (keep the original "Current" one)
            preview.querySelectorAll('[data-generated-preview]').forEach((el) => el.remove());
            preview.hidden = files.length === 0 && !preview.querySelector('img:not([data-generated-preview])');

            Array.from(files).forEach((file) => {
                if (!file.type.startsWith('image/')) return;
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'Preview';
                img.setAttribute('data-generated-preview', '');
                preview.appendChild(img);
            });
        };

        input.addEventListener('change', () => renderFiles(input.files));

        // Drag-and-drop
        ['dragenter', 'dragover'].forEach((ev) =>
            drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.add('is-dragover'); })
        );
        ['dragleave', 'drop'].forEach((ev) =>
            drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.remove('is-dragover'); })
        );
        drop.addEventListener('drop', (e) => {
            if (e.dataTransfer?.files?.length) {
                input.files = e.dataTransfer.files;
                renderFiles(input.files);
            }
        });
    });

    // 2) Character counters for textareas
    document.querySelectorAll('[data-counter-for]').forEach((counter) => {
        const ta = document.getElementById(counter.dataset.counterFor);
        if (!ta) return;
        const max = parseInt(ta.getAttribute('maxlength'), 10) || Infinity;
        const update = () => {
            const len = ta.value.length;
            counter.textContent = len;
            counter.style.color = len >= max ? 'var(--admin-danger)' : '';
        };
        ta.addEventListener('input', update);
        update();
    });

    // 3) Toggle-switch visual sync (the checkbox is hidden; the track reacts)
    document.querySelectorAll('.admin-toggle input[type="checkbox"]').forEach((cb) => {
        const sync = () => cb.closest('.admin-toggle')?.classList.toggle('is-on', cb.checked);
        cb.addEventListener('change', sync);
        sync();
    });

    // 4) Auto-slug from name (for category forms)
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    if (nameInput && slugInput) {
        let userEditedSlug = slugInput.value.trim().length > 0;
        slugInput.addEventListener('input', () => { userEditedSlug = slugInput.value.trim().length > 0; });
        nameInput.addEventListener('input', () => {
            if (userEditedSlug) return;
            slugInput.value = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .substring(0, 80);
        });
    }
}

/* ── Reveal Animations ── */
function initRevealAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.reveal').forEach(el => {
        observer.observe(el);
    });
}

document.addEventListener('DOMContentLoaded', initAdminForms);
