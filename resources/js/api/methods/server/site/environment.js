import {api_route} from "../../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Upload env file
 *
 * @param {String} siteId
 * @param {Object} variables
 *
 * @return {Object}
 */
export async function upload(siteId, variables) {
    try {
        const response = await api_route('v1.server.site.environment.upload', {site: siteId}).request({variables})

        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not upload env variables.')
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
        const response = await api_route('v1.server.site.environment.update', {site: siteId}).request(data)

        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not update environment variables.')
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
        const response = await api_route('v1.server.site.environment.delete', {site: siteId}).request({key})

        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not delete environment variable.')
    }
}