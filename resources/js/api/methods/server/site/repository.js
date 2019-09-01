import {api_route} from "../../../Router"

/**
 * Sync public key and web hooks
 *
 * @param {String} siteId
 * @return {Object}
 */
export async function sync(siteId) {
    try {
        await api_route('v1.server.site.repository.sync', {site: siteId}).request()
    } catch (e) {
        throw new ApiRequestError('Can not sync public key and web hooks.')
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