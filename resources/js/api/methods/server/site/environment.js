import {api_route} from "../../../Router"

/**
 * Upload env file
 *
 * @param {String} siteId
 * @param {Object} data
 *
 * @return {Object}
 */
export async function upload(siteId, data) {
    try {
        await api_route('v1.server.site.environment.upload', {site: siteId}).request(data)
    } catch (e) {
        throw new Error('Can not upload env file.')
    }
}

/**
 * Create/Update env variable
 *
 * @param {String} siteId
 * @param {Object} data
 * @param {String} data.key
 * @param {String} data.value
 *
 * @return {Object}
 */
export async function update(siteId, data) {
    try {
        await api_route('v1.server.site.environment.update', {site: siteId}).request(data)
    } catch (e) {
        throw new Error('Can not update environment variables.')
    }
}

/**
 * Remove env variable
 *
 * @param {String} siteId
 * @param {Object} key
 *
 * @return {Object}
 */
export async function remove(siteId, key) {
    try {
        await api_route('v1.server.site.environment.delete', {site: siteId}).request({key})
    } catch (e) {
        throw new Error('Can not delete environment variable.')
    }
}