import Vue from 'vue'
import router from './router'
import store from './store'
import i18n from './plugins/18n'
import Loader from '@vue/components/UI/Loader'

require('./bootstrap')
require('./http')
require('./api')
require('./plugins/echo')

Vue.component('Loader', Loader)

new Vue({
    el: '#app',
    router,
    store,
    i18n,
    metaInfo: {
        title: '',
        titleTemplate: '%s | SputnikCloud'
    },
});