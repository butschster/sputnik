import Vue from 'vue'
import router from './router'
import Gate from './policies/Gate'

import Loader from '@vue/components/UI/Loader'
import Copy from '@vue/components/UI/Copy'
import BadgeTimeFrom from "@vue/components/UI/Badge/TimeFrom"
import BadgeTaskStatus from "@vue/components/UI/Badge/TaskStatus"

import {mapGetters} from 'vuex'


require('./bootstrap')

import store from './vue/store'

Vue.use(Gate, {store})

Vue.component('Loader', Loader)
Vue.component('Copy', Copy)
Vue.component('BadgeTimeFrom', BadgeTimeFrom)
Vue.component('BadgeTaskStatus', BadgeTaskStatus)

new Vue({
    el: '#app',
    router,
    store,
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

        this.$store.dispatch('notifications/getNotifications')
    },
    computed: {
        ...mapGetters('auth', {
            user: 'getUser',
        }),
    }
});
