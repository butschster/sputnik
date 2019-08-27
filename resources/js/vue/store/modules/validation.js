import { ErrorBag } from 'vee-validate'

const state = {
    errors: new ErrorBag(),
}

// getters
const getters = {
    getErrors: (state) => state.errors,
    hasErrors: state => scope => state.errors.any(scope)
}

const actions = {
    setErrors({commit, state}, errors) {
        commit('setErrors', {errors})
    },
    clear({commit, state}) {
        commit('setErrors', {errors: new ErrorBag()})
    },
}

// mutations
const mutations = {
    setErrors(state, {errors}) {
        state.errors = errors
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}