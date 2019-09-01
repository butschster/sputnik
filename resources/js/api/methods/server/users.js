import {api_route} from "../../Router";

/**
 * Load servers list
 *
 * @param {String} serverId
 * @param {Number} page
 * @return {Object}
 */
export async function list(serverId, page) {
    try {
        const response = await api_route('v1.server.users', {server: serverId}).request({page})
        return response.data;
    } catch (e) {
        throw new Error('Can not load server users list.');
    }
}

/**
 * Create a new server user
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.user.store', {server: serverId}).request(data)
        return response.data.data;
    } catch (e) {
        throw new Error('Can not store server data.');
    }
}

/**
 * Load server user information by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function show(id) {
    try {
        const response = await api_route('v1.server.user.show', {user: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load server user information.');
    }
}

/**
 * Delete server user by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function remove(id) {
    try {
        const response = await api_route('v1.server.user.delete', {user: id}).request()
        return response.data;
    } catch (e) {
        throw new Error('Can not delete server user.');
    }
}