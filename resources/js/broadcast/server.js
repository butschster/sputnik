/**
 * @param {String} serverId
 * @return {Channel}
 */
export function serverChannel(serverId) {
    return this.private('server.' + serverId)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerCreated(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Created', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerUpdated(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Updated', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerDeleted(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Deleted', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerStatusChanged(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\StatusChanged', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerConfiguring(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Configuring', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerConfigured(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Configured', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerFailed(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Failed', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerKeysInstalled(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\KeysInstalled', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerSystemInformationChecked(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\SystemInformationChecked', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerEventCreated(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Event\\Created', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerTaskCreated(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Task\\Created', callback)
}

/**
 * @param {String} serverId
 * @param {Function} callback
 * @return {Channel}
 */
export function onServerPing(serverId, callback) {
    return this.serverChannel(serverId).listen('.App\\Events\\Server\\Ping\\Checked', callback)
}