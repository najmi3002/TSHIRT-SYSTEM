import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'pastel-pink': '#FFD1DC',
                'pastel-blue': '#B5D8FA',
                'pastel-green': '#C8F2C2',
                'pastel-yellow': '#FFF6B7',
                'pastel-purple': '#E2D6F9',
                'pastel-orange': '#FFE5B4',
                'pastel-gray': '#F7F7FA',
            },
        },
    },

    plugins: [forms],
};
