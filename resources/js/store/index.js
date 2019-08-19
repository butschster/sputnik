import Vue from 'vue'
import Vuex from 'vuex'
import validation from './modules/validation'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        validation
    },
})
