import {api_route} from "../../Router";

/**
 * Load server events
 *
 * @param {String} id
 * @param {Number} page
 *
 * @return {Object}
 */
export async function list(id, page) {
    try {
        const response = await api_route('v1.server.events', {server: id}).request({page})
        return response.data;
    } catch (e) {
        throw new Error('Can not load server events.');
    }
}

/**
 * Load last server event
 *
 * @param {String} id
 * @return {Object}
 */
export async function lastOne(id) {
    try {
        const response = await api_route('v1.server.event.last', {server: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load last server event.');
    }
}