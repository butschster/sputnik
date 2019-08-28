export default class SitePolicy {
    static create(user, server) {
        console.log(server)
        return server.can.create_site === true
    }
}
