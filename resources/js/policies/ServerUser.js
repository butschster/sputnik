export default class ServerUserPolicy {
    static create(user, server) {
        return server.can.create_user === true
    }
}
