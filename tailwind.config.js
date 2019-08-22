const {colors, fontFamily} = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        colors: colors,
        fontFamily: {
            body: ['Roboto', 'Helvetica', 'Arial', 'sans-serif'],
        },
        extend: {}
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ]
}
