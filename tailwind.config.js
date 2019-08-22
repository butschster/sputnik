const {boxShadow} = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        fontFamily: {
            body: ['Roboto', 'Helvetica', 'Arial', 'sans-serif'],
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ]
}
