export default class ServerSchedulerPolicy {
    static create(user, server) {
        return server.can.create_cron_job === true
    }
}
