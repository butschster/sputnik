function recurseMap(routes, parent, route) {
    return routes.map(r => {
        if (typeof r.children === 'undefined') {
            r.children = []
        }

        const path = r.path || '',
            name = r.name || '',
            hasChildren = r.children.length > 0

        if (path === parent || name === parent) {
            r.children.push(route)
        } else if(hasChildren) {
            r.children = recurseMap(r.children, parent, route)
        }

        return r
    })
}

export class Manager {
    constructor(routes) {
        this.routes = routes
    }

    get list() {
        return this.routes
    }

    addRoute(parent, route) {
        this.routes = recurseMap(this.routes, parent, route)
    }
}