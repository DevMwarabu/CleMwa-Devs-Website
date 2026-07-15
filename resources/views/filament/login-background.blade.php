<style>
    /* Base dark theme */
    body {
        background-color: #0f172a !important;
        color: #ffffff !important;
        margin: 0;
        overflow-x: hidden;
    }
    
    /* The image column (left side) */
    .split-left {
        position: fixed;
        top: 0;
        left: 0;
        width: 50vw;
        height: 100vh;
        background-image: url('/images/admin_login_bg.png');
        background-size: cover;
        background-position: center;
        border-right: none;
        z-index: 0;
    }
    
    /* Overlay for the image to make it blend with dark mode */
    .split-left::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(15,23,42,0) 0%, rgba(15,23,42,1) 100%);
    }

    /* Target Filament's main wrapper to put it on the right */
    .fi-simple-main {
        position: absolute !important;
        top: 0 !important;
        right: 0 !important;
        width: 50vw !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
        background: transparent !important;
    }
    
    .fi-simple-page {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
    
    /* Glassmorphism for the login card */
    .fi-simple-page section, .fi-simple-page .fi-panel-page {
        background: rgba(30, 41, 59, 0.6) !important;
        backdrop-filter: blur(24px) !important;
        -webkit-backdrop-filter: blur(24px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        border-radius: 1.5rem !important;
        padding: 2rem !important;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .split-left {
            display: none;
        }
        .fi-simple-main {
            width: 100vw !important;
            background-image: url('/images/admin_login_bg.png') !important;
            background-size: cover !important;
            background-position: center !important;
        }
        .fi-simple-main::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            z-index: -1;
        }
    }
</style>

<!-- Left side image container -->
<div class="split-left"></div>
