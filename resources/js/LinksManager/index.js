import * as links from "@js/router/links"
import {Manager} from "./Manager"

const manager = new Manager()

manager.sidebar.register(
    {
        title: 'user.sidebar.profile',
        link: links.profile(),
        icon: 'fa-key',
        order: 100,
    },
    {
        title: 'user.sidebar.teams',
        link: links.profileTeams(),
        icon: 'fa-chalkboard',
        order: 200,
    }
)

manager.serverSidebar.register(
    {
        link: (server) => links.serverModules(server),
        icon: 'fa-cubes',
        title: 'server.sections.modules',
        order: 100,
    },
    {
        link: (server) => links.serverFirewall(server),
        icon: 'fa-lock',
        title: 'server.sections.firewall',
        order: 200,
    },
    {
        link: (server) => links.serverUsers(server),
        icon: 'fa-users',
        title: 'server.sections.users',
        order: 300,
    },
    {
        link: (server) => links.serverSites(server),
        icon: 'fa-globe',
        title: 'server.sections.sites',
        module: 'nginx',
        order: 400,
    }
)

manager.serverTopSidebar.register(
    {
        title: 'server.sections.events',
        link: (server) => links.serverEvents(server),
        order: 100,
    },
    {
        title: 'server.sections.tasks',
        link: (server) => links.serverTasks(server),
        order: 200,
    },
    {
        title: 'server.sections.settings',
        link: (server) => links.serverSettings(server),
        order: 300,
    }
)


export default manager