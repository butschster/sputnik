/**
 * @param {String} siteId
 * @param {Function} callback
 * @return {Channel}
 */
export function onSiteDeployment(siteId, callback) {
    return this.channel(`site.${siteId}`).listen('.deployment', callback)
}