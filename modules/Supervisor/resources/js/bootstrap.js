import {api} from '@js/api'
import * as supervisorApi from './api/supervisor'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import SupervisorPage from '../vue/Pages/Supervisor/Index'
import {default as links, makeRoute} from "@js/router/links"

api.register('supervisor', supervisorApi)

Manager.addRoute('/server/:id', {
    path: '/server/:id/supervisor',
    name: 'server.supervisor',
    component: SupervisorPage,
    meta: {
        module: 'supervisor'
    }
})

LinksManager.serverSidebar.register(
    {
        link: (server) => makeRoute('server.supervisor', {id: server}),
        icon: 'fa-chart-bar',
        title: 'supervisor.section',
        module: 'supervisor'
    }
)