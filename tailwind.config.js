import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/**/*.php',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
        './resources/js/**/*.ts',
        './resources/js/**/*.js',
    ],

    safelist: [
        // Dynamic color classes used in blade loops
        { pattern: /^(bg|text|border|from|to|ring|hover:bg|hover:text|hover:border)-(sky|violet|emerald|orange|teal|indigo|fuchsia|red|yellow|green|blue|purple|pink)-(100|200|300|400|500|600|700|800|900)$/ },
        { pattern: /^(bg|text|border|from|to)-(sky|violet|emerald|orange|teal|indigo|fuchsia|red)-(400|500)\/(10|20|30|50)$/ },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['Raela', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Primary - dark backgrounds
                primary: {
                    400: '#1a1a2e',
                    500: '#0B0B0F',
                    600: '#050507',
                },
                // Deep teal brand color
                accent: {
                    300: '#b8d7ce',
                    400: '#4c8577',
                    500: '#145348',
                    600: '#0d4038',
                },
                // Soft green secondary accent
                accent2: {
                    300: '#ddf7c9',
                    400: '#c9f3ad',
                    500: '#b6eb91',
                    600: '#9cda70',
                },
            },
            animation: {
                aurora: 'aurora 15s ease-in-out infinite alternate',
            },
            keyframes: {
                aurora: {
                    '0%': { transform: 'translate(0%, 0%) scale(1)', opacity: '0.2' },
                    '33%': { transform: 'translate(5%, -5%) scale(1.1)', opacity: '0.3' },
                    '66%': { transform: 'translate(-3%, 3%) scale(0.95)', opacity: '0.25' },
                    '100%': { transform: 'translate(2%, -2%) scale(1.05)', opacity: '0.2' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },

    plugins: [
        forms,
        // Glass utility
        function ({ addUtilities }) {
            addUtilities({
                '.glass': {
                    background: 'var(--glass-bg, rgba(255, 255, 255, 0.04))',
                    'backdrop-filter': 'blur(12px)',
                    '-webkit-backdrop-filter': 'blur(12px)',
                },
                '.glass-dark': {
                    background: 'var(--glass-dark-bg, rgba(0, 0, 0, 0.3))',
                    'backdrop-filter': 'blur(12px)',
                    '-webkit-backdrop-filter': 'blur(12px)',
                },
            });
        },
    ],
};
