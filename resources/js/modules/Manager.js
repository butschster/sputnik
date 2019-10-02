export class Manager {
    constructor(modules) {
        this.modules = modules
    }

    init() {
        return new Promise((resolve, reject) => {
            this.modules.forEach(module => {
                try {
                    require(`@modules/${module}/resources/js/bootstrap`)
                } catch (e) {}
            })

            resolve()
        })
    }
}