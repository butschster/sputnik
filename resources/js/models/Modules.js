import Str from "@js/helpers/str";

export class Modules {
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
}