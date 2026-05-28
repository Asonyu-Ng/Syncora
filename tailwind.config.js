import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';
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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: colors.indigo,
                secondary: colors.purple,
                accent: colors.cyan,
                neutral: colors.slate,
                sidebar: {
                    DEFAULT: '#111827',
                    hover: '#1F2937',
                },
                success: colors.emerald,
                warning: colors.amber,
                danger: colors.rose,
                info: colors.sky,
            },
            borderRadius: {
                sm: 'var(--sync-radius-sm)',
                md: 'var(--sync-radius-md)',
                lg: 'var(--sync-radius-lg)',
                xl: 'var(--sync-radius-xl)',
                '2xl': 'var(--sync-radius-2xl)',
            },
            boxShadow: {
                soft: 'var(--sync-shadow-soft)',
                card: 'var(--sync-shadow-card)',
                focus: 'var(--sync-shadow-focus)',
            },
        },
    },

    plugins: [forms],
};
