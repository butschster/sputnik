import Vue from 'vue'
import Vuex from 'vuex'
import validation from './modules/validation'
import auth from './modules/auth'
import servers from './modules/servers'
import server from './modules/server'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        validation,
        auth,
        servers,
        server
    },
})
