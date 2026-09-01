import defaultTheme from 'tailwindcss/defaultTheme';

const themeScale = (name) => Object.fromEntries(
    [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950]
        .map((shade) => [shade, `rgb(var(--color-${name}-${shade}) / <alpha-value>)`]),
);

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/spatie/laravel-permission/resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Poppins', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', 'Poppins', 'sans-serif'],
                arabic: ['Amiri', 'Traditional Arabic', 'serif'],
            },
            colors: {
                primary: themeScale('primary'),
                gold: themeScale('gold'),
                secondary: themeScale('secondary'),
                brandText: '#1F1A17',
                brandBg: '#FFFFFF',
            },
            animation: {
                'shimmer': 'shimmer 2.5s linear infinite',
                'float': 'float 6s ease-in-out infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'marquee': 'marquee 30s linear infinite',
            },
            keyframes: {
                shimmer: {
                    'from': { backgroundPosition: '0 0' },
                    'to': { backgroundPosition: '-200% 0' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            boxShadow: {
                soft: '0 1px 2px 0 rgb(2 44 34 / 0.04), 0 4px 12px -2px rgb(2 44 34 / 0.08)',
                lift: '0 12px 32px -12px rgb(2 44 34 / 0.25)',
            },
            maxWidth: {
                '8xl': '88rem',
            },
        },
    },
    plugins: [],
};
