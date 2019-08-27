const state = {
    server: null,
}

// getters
const getters = {
    hasServer: (state) => typeof state.server === 'object',
    getServer: (state) => state.server
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
