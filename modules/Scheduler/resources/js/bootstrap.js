import {api} from '@js/api'
import * as serverCron from './api/cron'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import SchedulerPage from '../vue/Pages/Scheduler/Index'
import {makeRoute} from "@js/router/links"

api.register('serverCron', serverCron)

Manager.addRoute('/server/:id',  {
    path: '/server/:id/scheduler',
    name: 'server.scheduler',
    component: SchedulerPage,
})

LinksManager.serverSidebar.register(
    {
        link: (server) => makeRoute('server.scheduler', {id: server}),
        icon: 'fa-calendar-alt',
        title: 'server.sections.scheduler',
        order: 150,
    }
)