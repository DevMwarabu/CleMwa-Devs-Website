<style>
    /* =========================================================
       CleMwa CMS — Premium Sidebar Theme
       ========================================================= */

    /* ── Google Font ── */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    * { font-family: 'Inter', sans-serif; }

    /* ── Root palette ── */
    :root {
        --sidebar-bg:            #0c0f17;
        --sidebar-border:        rgba(255,255,255,0.06);
        --sidebar-width:         260px;
        --nav-item-radius:       10px;
        --nav-item-hover-bg:     rgba(255,255,255,0.06);
        --nav-item-active-bg:    rgba(99,102,241,0.18);
        --nav-item-active-color: #818cf8;
        --nav-item-color:        rgba(255,255,255,0.58);
        --nav-item-hover-color:  rgba(255,255,255,0.9);
        --group-label-color:     rgba(255,255,255,0.28);
        --accent:                #6366f1;
        --accent-glow:           rgba(99,102,241,0.35);
        --topbar-bg:             rgba(12,15,23,0.85);
        --content-bg:            #0f1218;
        --separator:             rgba(255,255,255,0.05);
        --livewire-progress-bar-color: #0ea5e9;
    }

    /* ── Page Shell ── */
    body {
        background: var(--content-bg) !important;
    }

    /* ── Sidebar container ── */
    .fi-sidebar {
        background: var(--sidebar-bg) !important;
        border-right: 1px solid var(--sidebar-border) !important;
        width: var(--sidebar-width) !important;
        backdrop-filter: blur(24px) !important;
        -webkit-backdrop-filter: blur(24px) !important;
        box-shadow: 4px 0 32px rgba(0,0,0,0.4) !important;
        transition: width 0.3s cubic-bezier(0.4,0,0.2,1) !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
    }

    /* ── Brand / Logo ── */
    .fi-sidebar-header {
        padding: 1.4rem 1.25rem 1rem !important;
        border-bottom: 1px solid var(--separator) !important;
        background: transparent !important;
        flex-shrink: 0 !important;
    }

    .fi-brand-name {
        font-size: 1.05rem !important;
        font-weight: 700 !important;
        letter-spacing: -0.02em !important;
        color: #fff !important;
        background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.6) 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
    }

    .fi-brand-logo {
        filter: brightness(0) invert(1) !important;
    }

    /* ── Scrollable nav area ── */
    .fi-sidebar-nav {
        flex: 1 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        padding: 0.75rem 0.75rem 1rem !important;
        scrollbar-width: thin !important;
        scrollbar-color: rgba(255,255,255,0.1) transparent !important;
    }

    .fi-sidebar-nav::-webkit-scrollbar {
        width: 4px !important;
    }
    .fi-sidebar-nav::-webkit-scrollbar-track {
        background: transparent !important;
    }
    .fi-sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.1) !important;
        border-radius: 9999px !important;
    }

    /* ── Navigation groups ── */
    .fi-sidebar-group {
        margin-bottom: 0.5rem !important;
    }

    .fi-sidebar-group-label {
        padding: 0.55rem 0.75rem 0.3rem !important;
        font-size: 0.65rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
        color: var(--group-label-color) !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        cursor: pointer !important;
        user-select: none !important;
        transition: color 0.2s ease !important;
    }

    .fi-sidebar-group-label:hover {
        color: rgba(255,255,255,0.55) !important;
    }

    /* Collapse chevron */
    .fi-sidebar-group-label button,
    .fi-sidebar-group-label-button {
        color: inherit !important;
        width: 100% !important;
        text-align: left !important;
        background: none !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        transition: color 0.2s ease !important;
    }

    /* Thin separator between groups */
    .fi-sidebar-group + .fi-sidebar-group {
        border-top: 1px solid var(--separator) !important;
        padding-top: 0.5rem !important;
        margin-top: 0.25rem !important;
    }

    /* ── Nav items ── */
    .fi-sidebar-item {
        border-radius: var(--nav-item-radius) !important;
        overflow: hidden !important;
        margin-bottom: 2px !important;
        animation: sidebarItemIn 0.35s ease both !important;
    }

    .fi-sidebar-item-button,
    .fi-sidebar-item a {
        display: flex !important;
        align-items: center !important;
        gap: 0.65rem !important;
        padding: 0.55rem 0.75rem !important;
        border-radius: var(--nav-item-radius) !important;
        color: var(--nav-item-color) !important;
        font-size: 0.835rem !important;
        font-weight: 450 !important;
        text-decoration: none !important;
        transition:
            background 0.2s ease,
            color 0.2s ease,
            transform 0.15s ease,
            box-shadow 0.2s ease !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .fi-sidebar-item-button:hover,
    .fi-sidebar-item a:hover {
        background: var(--nav-item-hover-bg) !important;
        color: var(--nav-item-hover-color) !important;
        transform: translateX(3px) !important;
    }

    /* Active state */
    .fi-sidebar-item-button.fi-active,
    .fi-sidebar-item a.fi-active,
    .fi-sidebar-item-button[aria-current="page"],
    .fi-sidebar-item a[aria-current="page"],
    .fi-sidebar-item.fi-active .fi-sidebar-item-button,
    .fi-sidebar-item.fi-active a {
        background: var(--nav-item-active-bg) !important;
        color: var(--nav-item-active-color) !important;
        font-weight: 600 !important;
        box-shadow: inset 0 0 0 1px rgba(99,102,241,0.25) !important;
    }

    /* Active left accent bar */
    .fi-sidebar-item-button.fi-active::before,
    .fi-sidebar-item a.fi-active::before,
    .fi-sidebar-item-button[aria-current="page"]::before,
    .fi-sidebar-item a[aria-current="page"]::before {
        content: '' !important;
        position: absolute !important;
        left: 0 !important;
        top: 15% !important;
        height: 70% !important;
        width: 3px !important;
        background: var(--accent) !important;
        border-radius: 0 4px 4px 0 !important;
        box-shadow: 0 0 10px var(--accent-glow) !important;
    }

    /* ── Nav item icons ── */
    .fi-sidebar-item-icon {
        width: 1.1rem !important;
        height: 1.1rem !important;
        flex-shrink: 0 !important;
        opacity: 0.7 !important;
        transition: opacity 0.2s ease, transform 0.2s ease !important;
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
    .fi-sidebar-item a:hover .fi-sidebar-item-icon {
        opacity: 1 !important;
        transform: scale(1.1) !important;
    }

    .fi-sidebar-item-button.fi-active .fi-sidebar-item-icon,
    .fi-sidebar-item a.fi-active .fi-sidebar-item-icon,
    .fi-sidebar-item-button[aria-current="page"] .fi-sidebar-item-icon {
        opacity: 1 !important;
        color: var(--nav-item-active-color) !important;
    }

    /* ── Badges ── */
    .fi-sidebar-item-badge {
        margin-left: auto !important;
        background: var(--accent) !important;
        color: #fff !important;
        font-size: 0.65rem !important;
        font-weight: 700 !important;
        padding: 0.1rem 0.4rem !important;
        border-radius: 9999px !important;
        box-shadow: 0 0 8px var(--accent-glow) !important;
    }

    /* ── Top navigation bar ── */
    .fi-topbar {
        background: var(--topbar-bg) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-bottom: 1px solid var(--sidebar-border) !important;
        box-shadow: 0 1px 20px rgba(0,0,0,0.3) !important;
    }

    /* ── Main content area ── */
    .fi-main {
        background: var(--content-bg) !important;
        transition: opacity 0.18s ease, transform 0.18s ease !important;
    }

    .fi-page {
        background: transparent !important;
    }

    /* ── SPA page-to-page crossfade (driven by livewire:navigate JS below) ── */
    html.fi-navigating .fi-main {
        opacity: 0 !important;
        transform: translateY(6px) !important;
    }

    /* ── Sidebar footer / user panel ── */
    .fi-sidebar-footer {
        padding: 0.85rem 0.75rem !important;
        border-top: 1px solid var(--separator) !important;
        background: transparent !important;
        flex-shrink: 0 !important;
    }

    .fi-user-menu-trigger {
        border-radius: var(--nav-item-radius) !important;
        padding: 0.5rem 0.65rem !important;
        background: transparent !important;
        transition: background 0.2s ease !important;
        color: var(--nav-item-color) !important;
    }

    .fi-user-menu-trigger:hover {
        background: var(--nav-item-hover-bg) !important;
        color: var(--nav-item-hover-color) !important;
    }

    /* ── Widgets & Cards ── */
    .fi-wi-account-widget,
    .fi-wi-filament-info-widget {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid var(--sidebar-border) !important;
        border-radius: 12px !important;
    }

    .fi-section-content-ctn {
        background: rgba(255,255,255,0.025) !important;
        border: 1px solid var(--sidebar-border) !important;
        border-radius: 12px !important;
    }

    /* ── Section headings ── */
    .fi-section-header {
        border-bottom: 1px solid var(--separator) !important;
    }

    /* ── Tables ── */
    .fi-ta-ctn {
        border-radius: 12px !important;
        border: 1px solid var(--sidebar-border) !important;
        overflow: hidden !important;
        background: rgba(255,255,255,0.025) !important;
    }

    /* ── Entry animations ── */
    @keyframes sidebarItemIn {
        from {
            opacity: 0;
            transform: translateX(-8px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Stagger children */
    .fi-sidebar-item:nth-child(1)  { animation-delay: 0.03s !important; }
    .fi-sidebar-item:nth-child(2)  { animation-delay: 0.06s !important; }
    .fi-sidebar-item:nth-child(3)  { animation-delay: 0.09s !important; }
    .fi-sidebar-item:nth-child(4)  { animation-delay: 0.12s !important; }
    .fi-sidebar-item:nth-child(5)  { animation-delay: 0.15s !important; }
    .fi-sidebar-item:nth-child(6)  { animation-delay: 0.18s !important; }
    .fi-sidebar-item:nth-child(7)  { animation-delay: 0.21s !important; }
    .fi-sidebar-item:nth-child(8)  { animation-delay: 0.24s !important; }
    .fi-sidebar-item:nth-child(9)  { animation-delay: 0.27s !important; }
    .fi-sidebar-item:nth-child(10) { animation-delay: 0.30s !important; }

    /* ── Sidebar group collapse animation ── */
    .fi-sidebar-group-items {
        overflow: hidden !important;
        transition: max-height 0.35s cubic-bezier(0.4,0,0.2,1),
                    opacity 0.25s ease !important;
    }

    /* ── Ripple shimmer on hover ── */
    .fi-sidebar-item-button::after,
    .fi-sidebar-item a::after {
        content: '' !important;
        position: absolute !important;
        inset: 0 !important;
        background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
            rgba(255,255,255,0.06) 0%,
            transparent 70%) !important;
        opacity: 0 !important;
        transition: opacity 0.3s ease !important;
        pointer-events: none !important;
        border-radius: var(--nav-item-radius) !important;
    }

    .fi-sidebar-item-button:hover::after,
    .fi-sidebar-item a:hover::after {
        opacity: 1 !important;
    }

    /* ── Stat / overview card polish ── */
    .fi-stats-overview-stat {
        background: rgba(255,255,255,0.03) !important;
        border: 1px solid var(--sidebar-border) !important;
        border-radius: 14px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .fi-stats-overview-stat:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.3) !important;
    }
</style>

<script>
    /* Track mouse for radial glow on sidebar items */
    document.addEventListener('DOMContentLoaded', function () {
        function attachRipple(el) {
            el.addEventListener('mousemove', function (e) {
                const rect = el.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width * 100).toFixed(1);
                const y = ((e.clientY - rect.top) / rect.height * 100).toFixed(1);
                el.style.setProperty('--mouse-x', x + '%');
                el.style.setProperty('--mouse-y', y + '%');
            });
        }

        function init() {
            document.querySelectorAll('.fi-sidebar-item-button, .fi-sidebar-item a')
                .forEach(attachRipple);
        }

        init();

        /* Re-run after Livewire navigations */
        document.addEventListener('livewire:navigated', init);
        document.addEventListener('livewire:navigate', init);
    });

    /* Crossfade the page content on every SPA navigation instead of an
       instant DOM swap (fires on every internal wire:navigate link/back-
       forward, not just full page loads — see html.fi-navigating above). */
    document.addEventListener('livewire:navigate', function () {
        document.documentElement.classList.add('fi-navigating');
    });
    document.addEventListener('livewire:navigated', function () {
        document.documentElement.classList.remove('fi-navigating');
    });
</script>
