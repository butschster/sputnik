const state = {
    server: null,
}

// getters
const getters = {
    hasServer: (state) => typeof state.server === 'object',
    getServer: (state) => state.server,
    isConfigured: (state, getters) => getters.hasServer && state.server.status == 'configured',
    isPending: (state, getters) => getters.hasServer && state.server.status == 'pending',
    isConfiguring: (state, getters) => getters.hasServer && state.server.status == 'configuring',
    isFailed: (state, getters) => getters.hasServer && state.server.status == 'failed'
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
