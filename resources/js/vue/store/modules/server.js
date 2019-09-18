import {Server} from "@js/models/Server"

const state = {
    server: null,
}

// getters
const getters = {
    hasServer: (state) => typeof state.server === 'object',
    getServer: (state) => state.server,
    model: (state) => new Server(state.server),
    isConfigured: (state, getters) => getters.hasServer && getters.model.isConfigured,
    isPending: (state, getters) => getters.hasServer && getters.mode.isPending,
    isConfiguring: (state, getters) => getters.hasServer && getters.mode.isConfiguring,
    isFailed: (state, getters) => getters.hasServer && new getters.mode.isFailed,
    links: (state, getters) => {
        if (!getters.hasServer) {
            return []
        }

        return new Server(state.server).links
    }
}

const actions = {
    setServer({commit}, server) {
        commit('setServer', server)
    },
    clearServer({commit}) {
        commit('setServer', null)
    }
}

// mutations
const mutations = {
    setServer(state, server) {
        state.server = server
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
