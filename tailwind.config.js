import defaultTheme from 'tailwindcss/defaultTheme';

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
                primary: {
                    50: '#effcf3',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#34c76b',
                    500: '#00a647',
                    600: '#00923F', // Brand Official Primary (#00923F)
                    700: '#007a34',
                    800: '#006437', // Brand Primary Dark (#006437)
                    900: '#004d2a',
                    950: '#002e1a',
                },
                gold: {
                    50: '#ffffea',
                    100: '#ffffc5',
                    200: '#ffff85',
                    300: '#fffb46',
                    400: '#FFF500', // Brand Accent (#FFF500)
                    500: '#dcd200',
                    600: '#afa600',
                    700: '#837b00',
                    800: '#5e5804',
                    900: '#423d08',
                    950: '#252202',
                },
                secondary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#75C5F0', // Brand Info/Secondary (#75C5F0)
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
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
