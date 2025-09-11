import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#B77400',
                secondary: '#FFC107',
                accent: '#4A3C2A', 
                light:'#FFF8E1'
                // primary: {
                //     50: '#fffbeb',
                //     100: '#fef3c7',
                //     200: '#fde68a',
                //     300: '#fcd34d',
                //     400: '#fbbf24',
                //     500: '#f59e0b',
                //     600: '#d97706',
                //     700: '#b45309', // Votre couleur
                //     800: '#92400e',
                //     900: '#78350f',
                //     DEFAULT: '#b45309', // Ajoutez cette ligne
                // },
                // secondary: {
                //     50: '#fefce8',
                //     100: '#fef9c3',
                //     200: '#fef08a',
                //     300: '#fde047',
                //     400: '#facc15',
                //     500: '#eab308',
                //     600: '#ca8a04',
                //     700: '#a16207',
                //     800: '#854d0e',
                //     900: '#713f12',
                //     DEFAULT: '#f59e0b', // Ajoutez cette ligne
                // },
                // accent: {
                //     50: '#fefce8',
                //     100: '#fef9c3',
                //     200: '#fef08a',
                //     300: '#fde047',
                //     400: '#facc15',
                //     500: '#eab308',
                //     600: '#ca8a04',
                //     700: '#a16207',
                //     800: '#92400e', // Votre couleur
                //     900: '#713f12',
                //     DEFAULT: '#92400e', // Ajoutez cette ligne
                // },
                // light: {
                //     DEFAULT: '#fffaeb', // Votre couleur
                // }
            }
        },
    },

    plugins: [forms],
};