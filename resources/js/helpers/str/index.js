class Str {
    constructor(value) {
        this.value = value
    }

    is(patterns) {
        if (!_.isArray(patterns)) {
            patterns = [patterns]
        }

        if (patterns.length === 0) {
            return true
        }

        for (let key in patterns) {
            let pattern = patterns[key]

            if (pattern == this.value) {
                return true
            }

            pattern = pattern.replace('\*', '.*')

            let re = new RegExp(pattern, 'g');

            if (this.value.match(re)) {
                return true
            }
        }

        return false
    }
}

function str(value) {
    return new Str(value)
}

export default str