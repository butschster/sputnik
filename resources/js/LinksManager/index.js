import * as links from "@js/router/links"
import {Manager} from "./Manager"

const manager = new Manager()

manager.sidebar.register(
    {
        title: 'user.sidebar.profile',
        link: links.profile(),
        icon: 'fa-key'
    },
    {
        title: 'user.sidebar.teams',
        link: links.profileTeams(),
        icon: 'fa-chalkboard'
    }
)

manager.serverSidebar.register(
    {
        link: (server) => links.serverModules(server),
        icon: 'fa-cubes',
        title: 'server.sections.modules'
    },
    {
        link: (server) => links.serverFirewall(server),
        icon: 'fa-lock',
        title: 'server.sections.firewall'
    },
    {
        link: (server) => links.serverUsers(server),
        icon: 'fa-users',
        title: 'server.sections.users'
    },
    {
        link: (server) => links.serverScheduler(server),
        icon: 'fa-calendar-alt',
        title: 'server.sections.scheduler'
    },
    {
        link: (server) => links.serverSupervisor(server),
        icon: 'fa-chart-bar',
        title: 'server.sections.supervisor',
        module: 'supervisor'
    },
    {
        link: (server) => links.serverDatabases(server),
        icon: 'fa-server',
        title: 'server.sections.database',
        module: ['mysql*', 'mariadb']
    },
    {
        link: (server) => links.serverSites(server),
        icon: 'fa-globe',
        title: 'server.sections.sites',
        module: 'nginx'
    }
)

manager.serverTopSidebar.register(
    {
        title: 'server.sections.events',
        link: (server) => links.serverEvents(server)
    },
    {
        title: 'server.sections.tasks',
        link: (server) => links.serverTasks(server)
    },
    {
        title: 'server.sections.settings',
        link: (server) => links.serverSettings(server)
    }
)


export default manager