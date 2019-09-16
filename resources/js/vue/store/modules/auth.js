import {api_route} from "@js/api/Router";
import i18next from "i18next"

const state = {
    user: null,
}

// getters
const getters = {
    getUser: (state) => state.user,
    getTeams: (state) => state.user.teams,
    getTeamsOptions: (state) => {
        return state.user.teams.map((team) => {
            return {label: team.name, value: team.id}
        })
    }
}

const actions = {
    async loadUser({commit}) {
        commit('setUser', window.user)

        return window.user
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

        i18next.changeLanguage(user.lang)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
