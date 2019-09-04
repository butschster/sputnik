export default class ServerPolicy {
    static create(user) {
        return user.can.server_create === true
    }

    static show(user, server) {
        return server.can.show === true
    }

    static update(user, server) {
        return server.can.update === true
    }

    static destroy(user, server) {
        return server.can.delete === true
    }
}
