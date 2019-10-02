// Layouts
import LayoutBasic from '@vue/Layouts/Basic'

// Servers
import ServersList from '@vue/Pages/Servers/Index'
import ServerShow from '@vue/Pages/Servers/Show'
import ServerSettings from '@vue/Pages/Servers/Settings'
import ServerModules from '@vue/Pages/Servers/Modules'
import ServerUsers from '@vue/Pages/Servers/Users/Index'
import ServerFirewall from '@vue/Pages/Servers/Firewall/Index'
import ServerEvents from '@vue/Pages/Servers/Events/Index'
import ServerTasks from '@vue/Pages/Servers/Tasks/Index'
import ServerTasksList from '@vue/Pages/Servers/Tasks/List'
import ServerTaskShow from '@vue/Pages/Servers/Tasks/Show'
import ServerScheduler from '@vue/Pages/Servers/Scheduler/Index'

// WebServer Supervisor
import ServerSupervisor from '@vue/Pages/Servers/WebServer/Supervisor/Index'

// WebServer Database
import ServerDatabase from '@vue/Pages/Servers/WebServer/Database/Index'

// WebServer Site
import ServerSites from '@vue/Pages/Servers/WebServer/Sites/Index'
import ServerSiteShow from '@vue/Pages/Servers/WebServer/Sites/Show'
import ServerSiteSettings from '@vue/Pages/Servers/WebServer/Sites/Settings'
import ServerSiteDeployment from '@vue/Pages/Servers/WebServer/Sites/Deployment'
import ServerSiteEnvironment from '@vue/Pages/Servers/WebServer/Sites/Environment'

// Account
import ProfileShow from "@vue/Pages/Profile/Show";
import NotificationsIndex from "@vue/Pages/Profile/Notifications";
import TeamsIndex from "@vue/Pages/Profile/Team/Index";
import TeamShow from "@vue/Pages/Profile/Team/Show";
import TeamMembers from "@vue/Pages/Profile/Team/Members";
import TeamBilling from "@vue/Pages/Profile/Team/Billing";
import TeamSubscription from "@vue/Pages/Profile/Team/Subscription/Index";

import NotFoundPage from '@vue/Pages/NotFound'
import {Manager} from "@js/router/manager";

const routes = [
    {
        path: '/',
        component: LayoutBasic,
        children: [
            {
                path: '/',
                name: 'servers',
                component: ServersList
            },
            {
                path: '/server/:id',
                component: ServerShow,
                meta: {
                    server: true
                },
                children: [
                    {
                        path: '/server/:id/modules',
                        name: 'server.modules',
                        component: ServerModules
                    },

                    {
                        path: '/server/:id/sites',
                        name: 'server.sites',
                        component: ServerSites
                    },
                    {
                        path: '/server/:id/sites/:site_id',
                        component: ServerSiteShow,
                        children: [
                            {
                                path: '/server/:id/sites/:site_id/settings',
                                name: 'server.site.show',
                                component: ServerSiteSettings
                            },
                            {
                                path: '/server/:id/sites/:site_id/deployment',
                                name: 'server.site.deployment',
                                component: ServerSiteDeployment
                            },
                            {
                                path: '/server/:id/sites/:site_id/env',
                                name: 'server.site.environment',
                                component: ServerSiteEnvironment
                            },
                        ]
                    },
                    {
                        path: '/server/:id/events',
                        name: 'server.events',
                        component: ServerEvents,
                    },
                    {
                        path: '/server/:id/tasks',
                        component: ServerTasks,
                        children: [
                            {
                                path: '/server/:id/tasks',
                                name: 'server.tasks',
                                component: ServerTasksList,
                            },
                            {
                                path: '/server/:id/tasks/:task_id',
                                name: 'server.task.show',
                                component: ServerTaskShow,
                            },
                        ]
                    },
                    {
                        path: '/server/:id/settings',
                        name: 'server.show',
                        component: ServerSettings,
                    },
                    {
                        path: '/server/:id/users',
                        name: 'server.users',
                        component: ServerUsers,
                    },

                    {
                        path: '/server/:id/firewall',
                        name: 'server.firewall',
                        component: ServerFirewall,
                    },
                    {
                        path: '/server/:id/scheduler',
                        name: 'server.scheduler',
                        component: ServerScheduler,
                    },
                    {
                        path: '/server/:id/supervisor',
                        name: 'server.supervisor',
                        component: ServerSupervisor,
                    },
                    {
                        path: '/server/:id/database',
                        name: 'server.databases',
                        component: ServerDatabase,
                    }
                ]
            },
            {
                path: '/account',
                name: 'profile',
                component: ProfileShow
            },
            {
                path: '/account/teams',
                name: 'profile.teams',
                component: TeamsIndex
            },
            {
                path: '/account/team/:id',
                component: TeamShow,
                children: [
                    {
                        path: '/account/team/:id/members',
                        name: 'profile.team.show',
                        component: TeamMembers
                    },
                    {
                        path: '/account/team/:id/subscription',
                        name: 'profile.team.subscription',
                        component: TeamSubscription
                    },
                    {
                        path: '/account/team/:id/billing',
                        name: 'profile.team.billing',
                        component: TeamBilling
                    }
                ]
            },
            {
                path: '/notifications',
                name: 'notifications',
                component: NotificationsIndex
            }
        ]
    },
    {
        path: '/404',
        name: '404',
        component: NotFoundPage
    },
    {
        path: '*',
        redirect: '/404'
    },
]

const manager = new Manager(routes)

export default manager
