import {ModuleAction} from "@js/models/ModuleAction"
import Str from '@js/helpers/str'

export class Module {
    constructor(module) {
        this.module = module
    }

    get title() {
        return this.module.title
    }

    get key() {
        return this.module.key
    }

    get categories() {
        return this.module.categories || []
    }

    get dependencies() {
        return this.module.dependencies || []
    }

    get conflicts() {
        return this.module.conflicts || []
    }

    get hasDependencies() {
        return this.dependencies.length > 0
    }

    get hasConflictsWithModules() {
        return this.conflicts.length > 0
    }

    get isInstallable() {
        return this.hasAction('install')
    }

    is(module) {
        if (_.isObject(module)) {
            return this.key === module.key
        }

        return this.key === module
    }

    checkDependencies(module) {
        return Str(this.key).is(module.dependencies)
    }

    checkConflicts(module) {
        return Str(module.key).is(this.conflicts)
    }

    hasAction(key) {
        return _.has(this.module, `actions.${key}`)
    }

    getAction(key) {
        return new ModuleAction(this.module['actions'][key])
    }
}