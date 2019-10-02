import methods from './methods'
import {ApiError, ApiRequestError} from "@js/errors"

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
            throw new ApiError(`Api method [${property}] not found`);
        }

        if (property == 'register') {
            return target[property];
        }

        return target[property]();
    },

    set(target, property, value, receiver) {

        if (typeof target[property] === 'undefined') {
            target[property] = value
            return true;
        }

        if (typeof target[property]() === 'object') {
            throw new ApiError('You can\'t override api methods');
        }

        return false;
    }
})