/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerTaskStatusChanged(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Task\\ChangedStatus', callback)
}
