import axios from 'axios'
import Vue from 'vue'
import VeeValidate from 'vee-validate'
import PortalVue from 'portal-vue'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

Vue.use(VeeValidate)
Vue.use(PortalVue)

require('./vue/plugins/errorHandler')
require('./vue/plugins/eventBus')
require('./vue/plugins/echo')
require('./vue/plugins/modal')
require('./vue/plugins/dropdown')
require('./vue/plugins/stripe')
require('./vue/plugins/moment')

require('./http')
require('./api')

require('./vue/plugins/clipboard')
require('./vue/directives/click-ouside')
