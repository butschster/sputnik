import Str from "@js/helpers/str";

export class ServerModules {
    constructor(modules) {
        this.modules = modules || []
    }

    get installed() {
        return this.modules.filter(m => m.status === 'installed')
    }

    get installedKeys() {
        return this.installed.map(m => m.key)
    }

    isInstalled(keys) {
        return this.installedKeys.filter(key => {
            return Str(key).is(keys)
        }).length > 0
    }

    find(keys) {
        return _.head(this.modules.filter(m => {
            return Str(m.key).is(keys)
        }))
    }
}