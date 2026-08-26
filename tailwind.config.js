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
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#3db56f',
                    500: '#12a04e',
                    600: '#00923F', // Brand Official Green (#00923F)
                    700: '#007b35',
                    800: '#006437', // Brand Deep Green (#006437)
                    900: '#004c2a',
                    950: '#002e1a',
                },
                forest: {
                    50: '#f2fbf5',
                    100: '#e1f7e9',
                    200: '#c5eed5',
                    300: '#98dfb6',
                    400: '#63c990',
                    500: '#38ad70',
                    600: '#00923F',
                    700: '#007a36',
                    800: '#006437',
                    900: '#004c2a',
                    950: '#002e1a',
                },
                gold: {
                    50: '#fefee8',
                    100: '#fffebc',
                    200: '#fffb80',
                    300: '#fff744',
                    400: '#FFF500', // Brand Ma'arif Yellow (#FFF500)
                    500: '#e0d500',
                    600: '#b5a400',
                    700: '#8f7b00',
                    800: '#756208',
                    900: '#63510c',
                    950: '#3a2d02',
                },
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
