// Layouts
import LayoutBasic from '@vue/Layouts/Basic'

// Servers
import ServersList from '@vue/Pages/Servers/Index'
import ServerShow from '@vue/Pages/Servers/Show'

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
                name: 'server.show',
                component: ServerShow
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
