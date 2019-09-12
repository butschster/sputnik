const {boxShadow, colors} = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        fontFamily: {
            body: ['Roboto', 'Helvetica', 'Arial', 'sans-serif'],
            mono: ['Source Code Pro', 'monospace']
        },
        extend: {
            colors: {
                blue: {
                    100: '#F5F5FF',
                    200: '#CCCCFF',
                    300: '#A3A3FF',
                    400: '#7A7AFF',
                    500: '#5252FF',
                    600: '#2929FF',
                    700: '#0000FF',
                    800: '#0000D6',
                    900: '#000085',
                    1000: '#45bbff'
                }
            }
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ]
}
