export default class ServerDatabasePolicy {
    static create(user, server) {
        return server.can.create_database === true
    }
}
