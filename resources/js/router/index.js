import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMeta from 'vue-meta'
import routes from '@vue/routes'
import NProgress from 'nprogress'
import store from '../vue/store'
import * as links from './links'

Vue.use(VueRouter)
Vue.use(VueMeta)

VueRouter.prototype.processError = function (error) {
    switch (error.response.status) {
        case 404:
            this.replace({name: '404'})
            break
    }
}

Vue.prototype.$link = links

const index = new VueRouter({
    routes,
    mode: 'history',
})

index.beforeEach(async (to, from, next) => {
    NProgress.start()

    if (!to.matched.length) {
        return next({name: '404'});
    }

    return next()
})

const hasMetaProperty = (route, prop) => {
    let has = route.meta.hasOwnProperty(prop)
    if (!has) {
        has = route.matched.filter(r => r.meta.hasOwnProperty(prop)).length > 0
    }

    return has
}

index.afterEach((to, from) => {
    NProgress.done()

    if (!hasMetaProperty(to, 'server')) {
        store.dispatch('server/clearServer')
    }
})


export default index