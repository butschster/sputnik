import {api_route} from "../../../Router"

/**
 * Get deployment script
 *
 * @param {String} siteId
 * @return {Object}
 */
export async function script(siteId) {
    try {
        const response = await api_route('v1.server.site.deploy.config', {site: siteId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not load deployment script.')
    }
}

/**
 * Run site deployment
 *
 * @param {String} siteId
 * @return {Object}
 */
export async function deploy(siteId) {
    try {
        const response = await api_route('v1.server.site.deploy', {site: siteId}).request()
        return response.data.data
    } catch (e) {
        throw new Error('Can not deploy site.')
    }
}