export default class ServerFirewallPolicy {
    static create(user, server) {
        return server.can.create_firewall === true
    }
}
