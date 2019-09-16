const fs = require('fs');
const path = require('path');

const {theme} = require('tailwindcss/resolveConfig')(require('../../../tailwind.config.js'))
const outPath = path.join(__dirname, '../_theme-colors.scss');

// If the file exists, delete it.
fs.unlink(outPath, err => {
    if (err && err.code !== 'ENOENT') return console.error(err);

    function storeVariable(name, color) {
        let line = `$color-${name}: ${color};\n`;
        fs.appendFile(outPath, line, err => {
            if (err) return console.error(err);

            console.log(`wrote ${name} color`);
        });
    }

    Object.keys(theme.colors).forEach(key => {

        if (typeof theme.colors[key] === 'string') {
            storeVariable(key, theme.colors[key])
        } else {
            Object.keys(theme.colors[key]).forEach(color => {
                storeVariable(`${key}-${color}`, theme.colors[key][color])
            })
        }
    });
});
