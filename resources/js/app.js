import Vue from 'vue'
import router from './router'
import Gate from './policies/Gate'
import store from './vue/store'
import i18n from './vue/plugins/i18n'
import Loader from '@vue/components/UI/Loader'
import Copy from '@vue/components/UI/Copy'
import BadgeTimeFrom from "@vue/components/UI/Badge/TimeFrom"
import BadgeTaskStatus from "@vue/components/UI/Badge/TaskStatus"
import BadgeStatus from "@vue/components/UI/Badge/Status"
import Table from "@vue/components/UI/Table/Table"
import {mapGetters} from 'vuex'

require('./bootstrap')

Vue.use(Gate, {store})

Vue.component('Loader', Loader)
Vue.component('Copy', Copy)
Vue.component('BadgeTimeFrom', BadgeTimeFrom)
Vue.component('BadgeTaskStatus', BadgeTaskStatus)
Vue.component('BadgeStatus', BadgeStatus)
Vue.component('DynamicTable', Table)

new Vue({
    el: '#app',
    router,
    store,
    i18n,
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
        this.$store.dispatch('servers/loadServers')
    },
    computed: {
        ...mapGetters('auth', {
            user: 'getUser',
        }),
    }
});
