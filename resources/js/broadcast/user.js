/**
 *
 * @param {String} userId
 * @return {Channel}
 */
export function userChannel(userId) {
    return this.private('users.' + userId)
}

/**
 *
 * @param {String} userId
 * @param {Function} callback
 * @return {Channel}
 */
export function onUserNotificationCreated(userId, callback) {
    return this.userChannel(userId).notification(callback)
}
