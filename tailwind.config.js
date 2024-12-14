import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'blur-sm': '0px 0px 2px 0px rgba(0, 0, 0, 0.25)'
            },
            backgroundColor: {
                background: '#F8F8F8',
                primary: '#F9C508'
            }
        },
    },
    plugins: [],
};
