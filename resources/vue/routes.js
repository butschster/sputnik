// Layouts
import LayoutBasic from '@vue/Layouts/Basic'

// Servers
import ServersList from '@vue/Pages/Servers/Index'
import ServerShow from '@vue/Pages/Servers/Show'
import ServerInformation from '@vue/Pages/Servers/Information'
import ServerSettings from '@vue/Pages/Servers/Settings'
import ServerUsers from '@vue/Pages/Servers/Users/Index'
import ServerDatabase from '@vue/Pages/Servers/Database/Index'
import ServerFirewall from '@vue/Pages/Servers/Firewall/Index'
import ServerEvents from '@vue/Pages/Servers/Events/Index'
import ServerTasks from '@vue/Pages/Servers/Tasks/Index'
import ServerSupervisor from '@vue/Pages/Servers/Supervisor/Index'
import ServerSites from '@vue/Pages/Servers/Sites/Index'
import ServerScheduler from '@vue/Pages/Servers/Scheduler/Index'
import ProfileShow from "@vue/Pages/Profile/Show";
import NotificationsIndex from "@vue/Pages/Profile/Notifications";
import TeamsIndex from "@vue/Pages/Profile/Team/Index";
import TeamShow from "@vue/Pages/Profile/Team/Show";
import TeamMembers from "@vue/Pages/Profile/Team/Members";
import TeamBilling from "@vue/Pages/Profile/Team/Billing";
import TeamSubscription from "@vue/Pages/Profile/Team/Subscription/Index";
import NotFoundPage from '@vue/Pages/NotFound'
import SearchIndex from '@vue/Pages/Search/Index'

export default [
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
                        path: '/server/:id',
                        name: 'server.show',
                        component: ServerSites,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/events',
                        name: 'server.events',
                        component: ServerEvents,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/tasks',
                        name: 'server.tasks',
                        component: ServerTasks,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/information',
                        name: 'server.information',
                        component: ServerInformation,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/settings',
                        name: 'server.settings',
                        component: ServerSettings,
                        meta: {
                            server: true
                        }
                    },

                    {
                        path: '/server/:id/users',
                        name: 'server.users',
                        component: ServerUsers,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/firewall',
                        name: 'server.firewall',
                        component: ServerFirewall,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/scheduler',
                        name: 'server.scheduler',
                        component: ServerScheduler,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/supervisor',
                        name: 'server.supervisor',
                        component: ServerSupervisor,
                        meta: {
                            server: true
                        }
                    },
                    {
                        path: '/server/:id/database',
                        name: 'server.database',
                        component: ServerDatabase,
                        meta: {
                            server: true
                        }
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
            },
            {
                path: '/search',
                name: 'search',
                component: SearchIndex
            },

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
