import {api_route} from "../../Router"

/**
 * Load server events
 *
 * @param {String} serverId
 * @param {Number} page
 *
 * @return {Object}
 */
export async function list(serverId, page) {
    try {
        const response = await api_route('v1.server.events', {server: serverId}).request({page})
        return response.data
    } catch (e) {
        throw new Error('Can not load server events.')
    }
}

/**
 * Load last server event
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function lastOne(serverId) {
    try {
        const response = await api_route('v1.server.event.last', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new Error('Can not load last server event.')
    }
}