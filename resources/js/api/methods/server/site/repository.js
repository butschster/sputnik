import {api_route} from "../../../Router"

/**
 * Sync webhook to the remote repository
 *
 * @param {String} siteId
 * @return {Object}
 */
export async function registerWebhook(siteId) {
    try {
        await api_route('v1.server.site.repository.webhook', {site: siteId}).request()
    } catch (e) {
        throw new ApiRequestError('Can not register web hook.')
    }
}

/**
 * Sync public key to the remote repository
 *
 * @param {String} siteId
 * @return {Object}
 */
export async function registerPublicKey(siteId) {
    try {
        await api_route('v1.server.site.repository.public_key', {site: siteId}).request()
    } catch (e) {
        throw new ApiRequestError('Can not register public key.')
    }
}

/**
 * Update repository data
 *
 *
 * @param {String} siteId
 *
 * @param {Object} data
 * @param {String} data.repository_provider
 * @param {String} data.repository_branch
 *
 * @return {Object}
 */
export async function update(siteId, data) {
    try {
        await api_route('v1.server.site.repository.update', {site: siteId}).request(data)
    } catch (e) {
        throw new ApiRequestError('Can not sync public key and web hooks.')
    }
}