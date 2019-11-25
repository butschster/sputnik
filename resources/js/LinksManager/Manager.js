class Link {
    constructor(data) {
        this._title = data.title
        this._link = data.link
        this._icon = data.icon
        this._order = data.order
        this.module = data.module
    }

    get icon() {
        return this._icon
    }

    get title() {
        return this._title
    }

    get link() {
        return this._link
    }

    link(...args) {
        if (typeof this._link === 'function') {
            return this._link(...args)
        }

        return this._link
    }

    get order() {
        return this._order
    }
}

class Links {
    constructor(links) {
        this._links = links || []
    }

    get links() {
        return _.sortBy(this._links, [
            link => link.order || 0
        ])
    }

    linksWithArgs(...args) {
        return this.links.map(link => {

            if (typeof link.link === 'function') {
                link.link = link.link(...args)
            }

            return link
        })
    }

    register(...links) {
        links.forEach(link => {
            this._links.push(
                new Link(link)
            )
        })
    }
}

export class Manager {
    constructor() {
        this._sidebar = new Links()
        this._serverSidebar = new Links()
        this._serverTopSidebar = new Links()
    }

    get sidebar() {
        return this._sidebar
    }

    get serverSidebar() {
        return this._serverSidebar
    }

    get serverTopSidebar() {
        return this._serverTopSidebar
    }
}