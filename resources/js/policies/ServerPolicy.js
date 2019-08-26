export default class ServerPolicy {
    static create(user) {
        return user.can.server_create === true
    }
}
