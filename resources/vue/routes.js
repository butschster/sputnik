// Layouts
import LayoutBasic from '@vue/Layouts/Basic'

// Servers
import ServersList from '@vue/Pages/Servers/Index'
import ServerShow from '@vue/Pages/Servers/Show'
import ServerInformation from '@vue/Pages/Servers/Information'
import ServerEvents from '@vue/Pages/Servers/Events'
import ServerTasks from '@vue/Pages/Servers/Tasks'
import ServerSettings from '@vue/Pages/Servers/Settings'
import ServerSites from '@vue/Pages/Servers/Sites'

// Profile
import ProfileShow from "@vue/Pages/Profile/Show";
import TeamsIndex from "@vue/Pages/Profile/Team/Index";
import TeamsShow from "@vue/Pages/Profile/Team/Show";

import NotFoundPage from '@vue/Pages/NotFound'

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
                children: [
                    {
                        path: '/server/:id',
                        name: 'server.show',
                        component: ServerSites
                    },
                    {
                        path: '/server/:id/events',
                        name: 'server.events',
                        component: ServerEvents
                    },
                    {
                        path: '/server/:id/tasks',
                        name: 'server.tasks',
                        component: ServerTasks
                    },
                    {
                        path: '/server/:id/information',
                        name: 'server.information',
                        component: ServerInformation
                    },
                    {
                        path: '/server/:id/settings',
                        name: 'server.settings',
                        component: ServerSettings
                    },
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
                name: 'profile.team.show',
                component: TeamsShow
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
