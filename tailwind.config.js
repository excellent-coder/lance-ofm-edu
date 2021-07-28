module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            container: {
                center: true,
                padding: {
                    DEFAULT: '0.4rem',
                    // DEFAULT: '1rem',
                    // sm: '2rem',
                    // lg: '4rem',
                    xl: '1rem',
                    // '2xl': '6rem',
                }
            },
            width: {
                '1/7': '14.2857143%',
            }
        },
        // screens: {
            // 'tablet': '640px',
            // => @media (min-width: 640px) { ... }

            // 'laptop': '1024px',
            // => @media (min-width: 1024px) { ... }

            // 'desktop': '1280px',
            // => @media (min-width: 1280px) { ... }
        // }
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
