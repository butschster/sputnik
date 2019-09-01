import {api} from "@js/api";

const state = {
    servers: null,
    loading: false,
}

// getters
const getters = {
    hasServers: (state) => state.servers && state.servers.length > 0,
    getServers: (state) => state.servers,
    isLoading: (state) => state.loading
}

const actions = {
    async loadServers({commit}, page = 1) {
        commit('setLoading', true)
        try {
            const servers = await api.server.list()
            commit('setServers', servers)
        } catch (e) {
            console.error(e)
        }

        commit('setLoading', false)
    },
    createServer({commit}, data) {
        return new Promise(async (resolve, reject) => {
            commit('setLoading', true)
            try {
                const server = await api.server.store(data)
                this.dispatch('servers/loadServers')
                resolve(server)
            } catch (e) {
                console.error(e)
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
