import ServerPolicy from './ServerPolicy'
import SitePolicy from "./SitePolicy"
import ServerDatabasePolicy from "./ServerDatabase"
import ServerSchedulerPolicy from "./ServerScheduler"
import ServerFirewallPolicy from "./ServerFirewall"
import ServerDaemonPolicy from "./ServerDaemon"
import ServerUserPolicy from "./ServerUser"

class Gate {
    constructor(store) {
        this.store = store

        this.policies = {
            server: ServerPolicy,
            server_database: ServerDatabasePolicy,
            server_scheduler: ServerSchedulerPolicy,
            server_firewall: ServerFirewallPolicy,
            server_daemon: ServerDaemonPolicy,
            server_user: ServerUserPolicy,
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
            return true
        }

        if (!this.policies.hasOwnProperty(type)) {
            return false
        }

        if (!this.policies[type].hasOwnProperty(action)) {
            return false
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
