import methods from './methods'

class ApiMethods {
    constructor(methods) {
        Object.keys(methods).forEach((key) => {
            let method = methods[key]
            this[key] = (...params) => {
                if (typeof method == 'function') {
                    return method(...params);
                }

                return method;
            }
        })
    }
}

class Api {
    constructor(methods) {
        Object.keys(methods).forEach((key) => this.register(key, methods[key]))
    }

    register(module, methods) {
        this[module] = () => new ApiMethods(methods)
    }
}

export default new Proxy(new Api(methods), {
    get(target, property) {
        if (typeof target[property] === 'undefined') {
            throw new Error(`Api method [${property}] not found`);
        }

        if (property == 'register') {
            return target[property];
        }

        try {
            return target[property]();
        } catch (e) {
            console.error(e.message);
        }
    },

    set(target, property, value, receiver) {

        if (typeof target[property] === 'undefined') {
            target[property] = value
            return true;
        }

        if (typeof target[property]() === 'object') {
            throw new Error('You can\'t override api methods');
        }

        return false;
    }
})