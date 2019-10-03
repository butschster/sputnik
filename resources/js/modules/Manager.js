export class Manager {
    constructor(modules) {
        this.modules = modules
    }

    init() {
        return new Promise((resolve, reject) => {
            this.modules.filter(module => module.bootstrap).forEach(module => {
                require(`@modules/${module.name}/resources/js/bootstrap`)
            })

            resolve()
        })
    }
}