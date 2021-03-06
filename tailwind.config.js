const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'bg-semi-75': 'rgba(0, 0, 0, 0.75)',
                transparent: 'transparent',
                current: 'currentColor',
                black: colors.black,
                white: colors.white,
                red: colors.red,
                orange: colors.orange,
                yellow: colors.yellow,
                green: colors.green,
                gray: colors.blueGray,
                indigo: {
                    100: '#e6e8ff',
                    300: '#b2b7ff',
                    400: '#7886d7',
                    500: '#6574cd',
                    600: '#5661b3',
                    800: '#2f365f',
                    900: '#191e38',
                },
            },
            screens: {
                'tablet': '640px',
                'mobile': '320px',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
