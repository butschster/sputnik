import ServerPolicy from './ServerPolicy';
import SitePolicy from "./SitePolicy";

class Gate {
    constructor(store) {
        this.store = store

        this.policies = {
            server: ServerPolicy,
            site: SitePolicy
        };
    }

    get user() {
        return this.store.getters['auth/getUser']
    }

    before() {
        return false;
    }


    allow(action, type, model = null) {
        if (this.before()) {
            return true;
        }

        return this.policies[type][action](this.user, model);
    }

    deny(action, type, model = null) {
        return !this.allow(action, type, model);
    }
}

export default {
    install(Vue, options) {
        Vue.prototype.$gate = new Gate(options.store)
    }
}
