import {Ziggy} from './ziggy';
import _ from 'lodash'

class UrlBuilder {
    constructor(name) {
        this.name = name;
        this.route = Ziggy.namedRoutes[this.name];

        if (typeof this.name === 'undefined') {
            throw new Error('Ziggy Error: You must provide a route name');
        } else if (typeof this.route === 'undefined') {
            throw new Error(`Ziggy Error: route '${this.name}' is not found in the route list`);
        }

        this.path = this.route.uri.replace(/^\//, '');
    }

    construct() {
        return this.path
    }

    route () {
        return this.route
    }

    method () {
        return _.first(this.route.methods)
    }
}

export default UrlBuilder;