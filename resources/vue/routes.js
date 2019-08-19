// Layouts
import LayoutBasic from '@vue/Layouts/Basic'

import NotFoundPage from '@vue/Pages/NotFound'

export default [
    {
        path: '/',
        component: LayoutBasic,
        children: [

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