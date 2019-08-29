export default class SitePolicy {
    static create(user, server) {
        return server.can.create_site === true
    }
}
