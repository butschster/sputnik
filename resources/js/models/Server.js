import * as links from "@js/router/links";

export class Server {
    constructor(server) {
        this.server = server
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

    get links() {
        if (!this.isConfigured) {
            return []
        }

        let items = [
            {
                link: links.serverOpenVPNClients(this.server),
                icon: 'fa-globe',
                title: 'server.sections.vpn_clients'
            },
            {
                link: links.serverFirewall(this.server),
                icon: 'fa-lock',
                title:'server.sections.firewall'
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
            },
        ]

        switch (this.server.type) {
            case 'openvpn':
                return items
        }

        items.push(
            {
                link: links.serverSites(this.server),
                icon: 'fa-globe',
                title: 'server.sections.sites'
            },
            {
                link: links.serverSupervisor(this.server),
                icon: 'fa-chart-bar',
                title: 'server.sections.supervisor'
            },
            {
                link: links.serverDatabases(this.server),
                icon: 'fa-server',
                title: 'server.sections.database'
            }
        )

        return items
    }
}
