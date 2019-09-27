import * as links from "@js/router/links"
import {Modules} from "./Modules"

export class Server {
    constructor(server) {
        this.server = server
        this.modules = new Modules(server.modules)
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

        let items = [
            {
                link: links.serverModules(this.server),
                icon: 'fa-cubes',
                title: 'server.sections.modules'
            },
            {
                link: links.serverFirewall(this.server),
                icon: 'fa-lock',
                title: 'server.sections.firewall'
            },
            {
                link: links.serverUsers(this.server),
                icon: 'fa-users',
                title: 'server.sections.users'
            },
            {
                link: links.serverScheduler(this.server),
                icon: 'fa-calendar-alt',
                title: 'server.sections.scheduler'
            }
        ]

        if (this.hasModule('supervisor')) {
            items.push({
                link: links.serverSupervisor(this.server),
                icon: 'fa-chart-bar',
                title: 'server.sections.supervisor'
            })
        }

        if (this.hasModule('mysql*')) {
            items.push({
                link: links.serverDatabases(this.server),
                icon: 'fa-server',
                title: 'server.sections.database'
            })
        }

        if (this.hasModule('nginx')) {
            items.push({
                link: links.serverSites(this.server),
                icon: 'fa-globe',
                title: 'server.sections.sites'
            })
        }

        if (this.hasModule('openvpn')) {
            items.push({
                link: links.serverOpenVPNClients(this.server),
                icon: 'fa-globe',
                title: 'server.sections.vpn_clients'
            })
        }

        return items
    }
}
