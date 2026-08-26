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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                display: ['Poppins', 'sans-serif'],
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
            boxShadow: {
                soft: '0 1px 2px 0 rgb(0 100 55 / 0.04), 0 4px 12px -2px rgb(0 100 55 / 0.08)',
                lift: '0 12px 32px -12px rgb(0 100 55 / 0.25)',
            },
            maxWidth: {
                '8xl': '88rem',
            },
        },
    },
    plugins: [],
};
