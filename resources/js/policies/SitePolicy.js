export default class SitePolicy {
    static create(user, server) {
        return server.can.create_site === true
    }

    static deploy(user, site) {
        return site.can.deploy === true
    }

    static pushDeploy(user, site) {
        return site.can['push-deploy'] === true
    }

    static update(user, site) {
        return site.can.update === true
    }

    static show(user, site) {
        return site.can.show === true
    }

    static destroy(user, site) {
        return site.can.delete === true
    }
}
