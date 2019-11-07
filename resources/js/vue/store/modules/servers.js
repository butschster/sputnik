import {api} from "@js/api"
import Vue from 'vue'
import { event } from 'vue-analytics'

const state = {
    servers: null,
    loading: false,
}

// getters
const getters = {
    hasServers: (state) => state.servers && state.servers.length > 0,
    getServers: (state) => state.servers,
    isLoading: (state) => state.loading,
}

const actions = {
    async loadServers({commit}, page = 1) {
        commit('setLoading', true)
        try {
            const servers = await api.server.list()
            commit('setServers', servers)
        } catch (e) {
            Vue.$handleError(e)
        }

        commit('setLoading', false)
    },
    createServer({commit}, data) {
        return new Promise(async (resolve, reject) => {
            commit('setLoading', true)
            try {
                const server = await api.server.store(data)

                event('server', 'create')

                this.dispatch('servers/loadServers')
                resolve(server)
            } catch (e) {
                Vue.$handleError(e)
                reject(e)
            }

            commit('setLoading', false)
        });
    }
}

// mutations
const mutations = {
    setServers(state, servers) {
        state.servers = servers
    },
    setLoading(state, status) {
        state.loading = status
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
