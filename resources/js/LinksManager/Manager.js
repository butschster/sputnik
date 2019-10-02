class Links {
    constructor(links) {
        this._links = links || []
    }

    get links() {
        return this._links
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
        links.forEach(link => this._links.push(link))
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