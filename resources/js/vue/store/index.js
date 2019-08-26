import Vue from 'vue'
import Vuex from 'vuex'
import validation from './modules/validation'
import auth from './modules/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        validation,
        auth
    },
})
