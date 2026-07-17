<style>
    /* ===================== Dark Canvas Login Theme ===================== */
    body {
        background-color: #000 !important;
        color: #ffffff !important;
        margin: 0;
        overflow-x: hidden;
    }

    #login-dot-canvas {
        position: fixed;
        inset: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        pointer-events: none;
        background: #000;
    }

    .login-vignette {
        position: fixed;
        inset: 0;
        z-index: 1;
        pointer-events: none;
        background: radial-gradient(circle at center, rgba(0,0,0,0) 0%, rgba(0,0,0,0.85) 100%);
    }

    .login-vignette::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 33%;
        background: linear-gradient(to bottom, #000, transparent);
    }

    /* Center everything, no split layout, no topbar */
    .fi-simple-layout {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        background: transparent !important;
    }

    .fi-simple-main-ctn {
        min-height: 100vh;
    }

    .fi-simple-page {
        max-width: 26rem !important;
        width: 100%;
    }

    /* Glass card */
    .fi-simple-main {
        background: rgba(255, 255, 255, 0.04) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
        border-radius: 1.5rem !important;
        padding: 2.5rem !important;
    }

    /* Header */
    .fi-simple-header-heading {
        color: #fff !important;
        font-weight: 700 !important;
        letter-spacing: -0.025em !important;
        font-size: 2rem !important;
        text-align: center !important;
        margin-bottom: 0.25rem !important;
    }

    .fi-simple-header-subheading {
        color: rgba(255, 255, 255, 0.5) !important;
        font-weight: 300 !important;
        font-size: 1rem !important;
    }

    .fi-logo {
        color: #fff !important;
        filter: brightness(0) invert(1);
    }

    /* Inputs */
    .fi-input-wrapper {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        border-radius: 0.75rem !important;
        backdrop-filter: blur(4px);
        transition: all 0.3s ease !important;
    }

    .fi-input-wrapper:focus-within {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 0 0 1px rgba(14, 165, 233, 0.5) !important;
    }

    .fi-input {
        color: #fff !important;
    }

    .fi-input::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    .fi-fo-field-wrp-label,
    label {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Primary button */
    .fi-btn-color-primary {
        background: #0ea5e9 !important;
        color: #fff !important;
        border: none !important;
        border-radius: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
    }

    .fi-btn-color-primary:hover {
        background: #38bdf8 !important;
        box-shadow: 0 0 20px rgba(14, 165, 233, 0.4) !important;
    }

    /* Links (forgot password, etc.) */
    .fi-simple-main a {
        color: rgba(255, 255, 255, 0.5) !important;
        transition: color 0.2s ease;
    }

    .fi-simple-main a:hover {
        color: #fff !important;
    }
</style>

<canvas id="login-dot-canvas"></canvas>
<div class="login-vignette"></div>

<script>
    (function () {
        const canvas = document.getElementById('login-dot-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const SPACING = 22;
        const DOT_RADIUS = 1.4;
        let dots = [];
        let width, height, dpr;

        function buildGrid() {
            dpr = window.devicePixelRatio || 1;
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            const cols = Math.ceil(width / SPACING) + 1;
            const rows = Math.ceil(height / SPACING) + 1;
            const centerX = cols / 2;
            const centerY = rows / 2;

            dots = [];
            for (let x = 0; x < cols; x++) {
                for (let y = 0; y < rows; y++) {
                    const dist = Math.hypot(x - centerX, y - centerY);
                    dots.push({
                        x: x * SPACING,
                        y: y * SPACING,
                        revealDelay: dist * 0.025 + Math.random() * 0.4,
                        seed: Math.random() * 1000,
                        flickerSpeed: 0.3 + Math.random() * 0.5,
                    });
                }
            }
        }

        function draw(timestamp) {
            const elapsed = timestamp / 1000;
            ctx.clearRect(0, 0, width, height);
            ctx.fillStyle = '#ffffff';

            for (const dot of dots) {
                let opacity;
                if (prefersReducedMotion) {
                    opacity = 0.12;
                } else {
                    const revealProgress = Math.min(Math.max((elapsed - dot.revealDelay) / 0.6, 0), 1);
                    const flicker = 0.5 + 0.5 * Math.sin(elapsed * dot.flickerSpeed + dot.seed);
                    opacity = revealProgress * (0.08 + flicker * 0.22);
                }

                if (opacity > 0.01) {
                    ctx.globalAlpha = opacity;
                    ctx.beginPath();
                    ctx.arc(dot.x, dot.y, DOT_RADIUS, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            ctx.globalAlpha = 1;

            if (!prefersReducedMotion) {
                requestAnimationFrame(draw);
            }
        }

        buildGrid();
        requestAnimationFrame(draw);

        let resizeTimeout;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(buildGrid, 150);
        });
    })();
</script>
