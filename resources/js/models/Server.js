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
                title: 'VPN Clients'
            },
            {
                link: links.serverFirewall(this.server),
                icon: 'fa-globe',
                title: 'Firewall'
            },
            {
                link: links.serverUsers(this.server),
                icon: 'fa-users',
                title: 'Users'
            },
            {
                link: links.serverScheduler(this.server),
                icon: 'fa-calendar-alt',
                title: 'Scheduler'
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
                title: 'Sites'
            },
            {
                link: links.serverSupervisor(this.server),
                icon: 'fa-chart-bar',
                title: 'Supervisor'
            },
            {
                link: links.serverDatabases(this.server),
                icon: 'fa-server',
                title: 'Database'
            }
        )

        return items
    }
}