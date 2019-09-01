import {api} from "@js/api"

const state = {
    loading: false,
    all: []
}

const getters = {
    hasNotifications(state) {
        return state.all.length > 0
    },
    notifications(state) {
        return state.all
    },
    unreadNotifications(state) {
        return state.all.filter(notification => !notification.read)
    },
    totalUnreadNotifications(state, getters) {
        return getters.unreadNotifications.length
    },
    hasUnreadNotifications(state, getters) {
        return getters.totalUnreadNotifications > 0
    }
}

const actions = {
    async getNotifications({commit, state}) {
        state.loading = true

        try {
            const notifications = await api.notifications.list()
            commit('setNotifications', notifications)
        } catch (e) {
            console.error(e)
        }

        state.loading = false
    },
    async markNotificationsAsRead({state, commit}, ids) {
        state.loading = true

        try {
            const response = await api.notifications.read(ids)

            commit('setNotifications', state.all.map(notification => {
                if (ids.indexOf(notification.id) !== -1) {
                    notification.read = true
                }

                return notification
            }))
        } catch (e) {
            console.error(e)
        }

        state.loading = false
    }
}

const mutations = {
    setNotifications(state, notifications) {
        state.all = notifications
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
