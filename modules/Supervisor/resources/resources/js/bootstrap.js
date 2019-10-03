import {api} from '@js/api'
import * as serverSupervisor from './api/supervisor'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import SupervisorPage from '../vue/Pages/Supervisor/Index'
import {default as links, makeRoute} from "@js/router/links"

api.register('serverSupervisor', serverSupervisor)

Manager.addRoute('/server/:id', {
    path: '/server/:id/supervisor',
    name: 'server.supervisor',
    component: SupervisorPage,
})

LinksManager.serverSidebar.register(
    {
        link: (server) => makeRoute('server.supervisor', {id: server}),
        icon: 'fa-chart-bar',
        title: 'server.sections.supervisor',
        module: 'supervisor'
    }
)