import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMeta from 'vue-meta'
import routes from '@vue/routes'
import NProgress from 'nprogress'
import store from '../vue/store'

Vue.use(VueRouter)
Vue.use(VueMeta)

VueRouter.prototype.processError = function(error) {
    switch(error.response.status) {
        case 404:
            this.replace({name: '404'})
            break
    }
}

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

index.afterEach((to, from) => {
    NProgress.done()

    if (!to.meta.hasOwnProperty('server')) {
        store.dispatch('server/clearServer')
    }
})


export default index