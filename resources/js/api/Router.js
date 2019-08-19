import UrlBuilder from './UrlBuilder'
import {Ziggy} from './ziggy'
import axios from 'axios'

function prepareFormData(formData, data, previousKey) {
    if (data instanceof Object) {
        Object.keys(data).forEach(key => {
            const value = data[key];

            if (value instanceof File) {
                formData.append(key, value);
                return;

            } else if (value instanceof Object && !Array.isArray(value)) {
                return prepareFormData(formData, value, key);
            }

            if (previousKey) {
                key = `${previousKey}[${key}]`;
            }

            if (Array.isArray(value)) {
                value.forEach((val, index) => {
                    if (val instanceof Object && !Array.isArray(val)) {
                        return prepareFormData(formData, val, `${key}[${index}]`);
                    } else {
                        formData.append(`${key}[]`, val);
                    }
                });
            } else if (!_.isNull(value)) {
                formData.append(key, value);
            }
        });
    }
}

function makeFormData(data) {
    let formData = new FormData();
    prepareFormData(formData, data);
    return formData;
}

class Router extends String {
    constructor(name, params) {
        super();

        let routeName = null
        let urlParams = {}

        if (_.isObject(name)) {
            routeName = _.get(params, 'name')
            urlParams = _.get(params, 'params')
        } else if (_.isString(name)) {
            routeName = name
            urlParams = params
        }

        this.name = routeName
        this.urlParams = this.normalizeParams(urlParams)
        this.queryParams = this.normalizeParams(urlParams)
        this.route = new UrlBuilder(routeName)
    }

    normalizeParams(params) {
        if (typeof params === 'undefined')
            return {};

        params = typeof params !== 'object' ? [params] : params;
        this.numericParamIndices = Array.isArray(params);

        return Object.assign({}, params);
    }

    with(params) {
        this.urlParams = this.normalizeParams(params);
        return this;
    }

    withQuery(params) {
        Object.assign(this.queryParams, params);
        return this;
    }

    hydrateUrl() {
        let tags = this.urlParams,
            paramsArrayKey = 0,
            template = this.route.construct(),
            params = template.match(/{([^}]+)}/gi),
            needDefaultParams = false;

        if (params && params.length != Object.keys(tags).length) {
            needDefaultParams = true
        }

        return template.replace(
            /{([^}]+)}/gi,
            function (tag) {
                let keyName = tag.replace(/\{|\}/gi, '').replace(/\?$/, ''),
                    key = this.numericParamIndices ? paramsArrayKey : keyName,
                    defaultParameter = Ziggy.defaultParameters[keyName];

                if (defaultParameter && needDefaultParams) {
                    if (this.numericParamIndices) {
                        tags = Object.values(tags)
                        tags.splice(key, 0, defaultParameter)
                    } else {
                        tags[key] = defaultParameter
                    }
                }

                paramsArrayKey++;
                if (typeof tags[key] !== 'undefined') {
                    delete this.queryParams[key];
                    return tags[key].id || encodeURIComponent(tags[key]);
                }
                if (tag.indexOf('?') === -1) {
                    throw new Error(`Ziggy Error: '${keyName}' key is required for route '${this.name}'`);
                } else {
                    return '';
                }
            }.bind(this)
        );
    }

    matchUrl() {
        let tags = this.urlParams,
            template = this.route.construct();

        let windowUrl = window.location.pathname;

        let searchTemplate = template.replace(/(\{[^\}]*\})/gi, '[^\/\?]+');
        let urlWithTrailingSlash = windowUrl.replace(/\/?$/, '/');
        return new RegExp("^" + searchTemplate + "\/$").test(urlWithTrailingSlash);
    }

    constructQuery() {
        if (Object.keys(this.queryParams).length === 0)
            return '';

        let queryString = '?';

        Object.keys(this.queryParams).forEach(function (key, i) {
            queryString = i === 0 ? queryString : queryString + '&';
            queryString += key + '=' + encodeURIComponent(this.queryParams[key]);
        }.bind(this));

        return queryString;
    }

    current(name = null) {
        let routeNames = Object.keys(Ziggy.namedRoutes);

        let currentRoute = routeNames.filter(name => {
            return new Router(name).matchUrl();
        })[0];

        return name ? (name == currentRoute) : currentRoute
    }

    parse() {
        this.return = this.hydrateUrl() + this.constructQuery()
    }

    url() {
        this.parse()
        return `/${this.return}`
    }

    request(data, has_files = false) {
        let params = {
            method: this.route.method().toLowerCase(),
            url: this.url(),
        }

        switch (params.method) {
            case 'get':
                params.params = data
                break
            default:
                params.data = data
                break
        }

        if (has_files) {
            params.data = makeFormData(params.data)
        }

        return axios(params);
    }

    toString() {
        return this.url()
    }

    valueOf() {
        return this.url()
    }
}

function api_route(name, params) {
    return new Router(name, params)
}

export {
    api_route
}

export default Router