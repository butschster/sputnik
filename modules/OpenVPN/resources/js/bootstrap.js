import {api} from '@js/api'
import * as openVpnClient from './api/client'
import Manager from '@vue/routes'
import LinksManager from '@js/LinksManager'
import ClientsPage from '../vue/Pages/Clients/Index'
import {makeRoute} from "@js/router/links";

api.register('openVpnClient', openVpnClient)

Manager.addRoute('/server/:id',  {
    path: '/server/:id/openvpn',
    name: 'server.openvpn.clients',
    component: ClientsPage,
})

LinksManager.serverSidebar.register(
    {
        link: (server) => makeRoute('server.openvpn.clients', {id: server}),
        icon: 'fa-globe',
        title: 'openvpn.clients.section',
        module: 'openvpn'
    }
)