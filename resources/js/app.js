import Vue from 'vue'
import router from './router'
import Gate from './policies/Gate'
import Loader from '@vue/components/UI/Loader'
import {mapGetters} from 'vuex'

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
    created() {

        this.$store.dispatch('auth/loadUser').then((e) => {
            this.$echo.onUserNotificationCreated(this.user.id, (e) => {
                this.$store.dispatch('notifications/getNotifications')
            })
        })

        this.$store.dispatch('servers/loadServers')

        this.$store.dispatch('notifications/getNotifications')
    },
    computed: {
        ...mapGetters('auth', {
            user: 'getUser',
        }),
    }
});
