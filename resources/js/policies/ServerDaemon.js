export default class ServerDaemonPolicy {
    static create(user, server) {
        return server.can.create_daemon === true
    }
}
