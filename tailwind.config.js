const {boxShadow} = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        fontFamily: {
            body: ['Roboto', 'Helvetica', 'Arial', 'sans-serif'],
            mono: ['Source Code Pro', 'monospace']
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ]
}
