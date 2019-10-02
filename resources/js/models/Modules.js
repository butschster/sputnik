
export class Modules {
    constructor(modules) {
        this.modules = Object.values(modules) || []
    }

    get installable() {
        return this.modules.filter(m => _.has(m, 'actions.install'))
    }
}