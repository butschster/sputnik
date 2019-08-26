import Vue from 'vue'
import router from './router'
import Gate from './policies/Gate'
import Loader from '@vue/components/UI/Loader'

require('./bootstrap')

import store from './vue/store'

Vue.use(Gate, {store})

Vue.component('Loader', Loader)

new Vue({
    el: '#app',
    router,
    store,
    //i18n,
    metaInfo: {
        title: '',
        titleTemplate: '%s | SputnikCloud'
    },
    created: function () {
        this.$store.dispatch('auth/loadUser')
        this.$store.dispatch('servers/loadServers')
    }
});
