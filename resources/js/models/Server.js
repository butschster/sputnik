import LinksManager from '@js/LinksManager'
import {ServerModules} from "./ServerModules"

export class Server {
    constructor(server) {
        this.server = server
        this.modules = new ServerModules(server.modules)
        this._links = LinksManager.serverSidebar.linksWithArgs(this.server)
    }

    get isConfigured() {
        return this.server.status == 'configured'
    }

    get isPending() {
        return this.server.status == 'pending'
    }

    get isConfiguring() {
        return this.server.status == 'configuring'
    }

    get isFailed() {
        return this.server.status == 'failed'
    }

    /**
     * @param {String|Array} keys
     * @return Boolean
     */
    hasModule(keys) {
        return this.modules.isInstalled(keys)
    }

    get links() {
        if (!this.isConfigured) {
            return []
        }

        return this._links.filter(link => {
            if (!_.has(link, 'module')) {
                return true
            }

            return this.hasModule(link.module)
        })
    }
}
