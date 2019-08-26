import {api_route} from "@js/api/Router";

const state = {
    servers: null,
    loading: false,
}

// getters
const getters = {
    getServers: (state) => {
        return state.servers
    },
    isLoading: (state) => {
        return state.loading
    }
}

const actions = {
    async loadServers({commit}) {
        commit('setLoading', true)
        try {
            const response = await api_route('v1.servers').request()
            commit('setServers', response.data.data)
        } catch (e) {
            console.error(e)
        }

        commit('setLoading', false)
    },
    createServer({commit}, data) {
        return new Promise(async (resolve, reject) => {
            commit('setLoading', true)
            try {
                const response = await api_route('v1.server.store').request(data)
                this.dispatch('servers/loadServers')
                resolve(response.data.data)
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
