import {api} from '@js/api'
import * as mysqlDatabase from './api/database'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import DatabasePage from '../vue/Pages/Database/Index'
import {makeRoute} from "@js/router/links";

api.register('mysqlDatabase', mysqlDatabase)

Manager.addRoute('/server/:id', {
    path: '/server/:id/mysql',
    name: 'server.mysql',
    component: DatabasePage,
})

LinksManager.serverSidebar.register(
    {
        link: (server) => makeRoute('server.mysql', {id: server}),
        icon: 'fa-server',
        title: 'mysql.section',
        module: ['mysql*', 'mariadb'],
        order: 1000,
    }
)