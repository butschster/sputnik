const fs = require('fs');
const path = require('path');
const {boxShadow, colors} = require('tailwindcss/defaultTheme')
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

    // Iterate through the colors property of the tailwinds config
    // and create a scss variable for each color.
    Object.keys(colors).forEach(key => {

        if (typeof colors[key] === 'string') {
            storeVariable(key, colors[key])
        } else {
            Object.keys(colors[key]).forEach(color => {
                storeVariable(`${key}-${color}`, colors[key][color])
            })
        }
    });


});