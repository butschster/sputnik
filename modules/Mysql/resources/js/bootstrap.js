import {api} from '@js/api'
import * as mysqlDatabase from './api/database'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import DatabasePage from '../vue/Pages/Database/Index'
import {makeRoute} from "@js/router/links";

api.register('mysqlDatabase', mysqlDatabase)

const databaseTypes = ['mysql56', 'mysql8', 'mariadb']

databaseTypes.forEach(type => {

    Manager.addRoute('/server/:id', {
        path: `/server/:id/${type}`,
        name: `server.${type}`,
        component: DatabasePage,
        meta: {
            database: type
        }
    })

    LinksManager.serverSidebar.register(
        {
            link: (server) => makeRoute(`server.${type}`, {id: server}),
            icon: 'fa-server',
            title: `mysql.section.${type}`,
            module: [type],
            order: 1000,
        }
    )

})
