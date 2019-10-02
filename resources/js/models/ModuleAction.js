export class ModuleAction {
    constructor(action) {
        this.action = action
    }

    get fields() {
        return this.action.fields || []
    }

    get settings() {
        return this.action.default_settings || []
    }

    get key() {
        return this.action.key
    }

    get name() {
        return this.action.name
    }

    get hasFields() {
        return this.fields.length > 0
    }
}