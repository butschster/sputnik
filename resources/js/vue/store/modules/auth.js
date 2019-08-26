import {api_route} from "@js/api/Router";

const state = {
    user: null,
}

// getters
const getters = {
    getUser: (state) => {
        return state.user
    },
    getTeams: (state) => {
        return state.user.teams
    },
    getTeamsOptions: (state) => {
        return state.user.teams.map((team) => {
            return {label: team.name, value: team.id}
        })
    }
}

const actions = {
    async loadUser({commit}) {
        commit('setUser', window.user)
    },
    async updateUser({commit}) {
        const response = await api_route('v1.user.profile').request()
        commit('setUser', response.data.data)
    }
}

// mutations
const mutations = {
    setUser(state, user) {
        state.user = user
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
