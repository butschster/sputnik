import axios from 'axios'
import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2'
import VeeValidate from 'vee-validate'
import PortalVue from 'portal-vue'
import Notifications from 'vue-notification'
import Moment from 'vue-moment'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

Vue.use(VeeValidate)
Vue.use(VueSweetalert2)
Vue.use(PortalVue)
Vue.use(Notifications)
Vue.use(Moment)

require('./vue/plugins/errorHandler')
require('./vue/plugins/eventBus')
require('./vue/plugins/echo')
require('./vue/plugins/modal')
require('./vue/plugins/dropdown')
require('./vue/plugins/stripe')

require('./http')
require('./api')

//import i18n from './vue/plugins/18n'
require('./vue/plugins/clipboard')
require('./vue/directives/click-ouside')
