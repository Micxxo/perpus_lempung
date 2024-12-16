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
                'instrument-sans': ['InstrumentSans', 'sans-serif'],
            },
            boxShadow: {
                'blur-xs': '0px 0px 2px 0px rgba(0, 0, 0, 0.25)',
                'blur-sm': '0px 0px 4px 0px rgba(0, 0, 0, 0.25)',
                'book-shadow': '8px 7px 4px 0px rgba(0, 0, 0, 0.25)'
            },
            colors: {
                background: "hsl(var(--background))",
                secondary: "hsl(var(--secondary))",
                accent: "hsl(var(--accent))",
                primary: {
                    DEFAULT: "hsl(var(--primary))",
                    foreground: "hsl(var(--primary-foreground))",
                  },
            }
        },
    },
    plugins: [],
};
