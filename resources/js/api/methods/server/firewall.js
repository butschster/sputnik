import {api_route} from "../../Router";

/**
 * Load servers firewall rules
 *
 * @param {String} serverId
 * @param {Number} page
 * @return {Object}
 */
export async function list(serverId, page) {
    try {
        const response = await api_route('v1.server.firewall.rules', {server: serverId}).request({page})
        return response.data;
    } catch (e) {
        throw new Error('Can not load server firewall rules list.');
    }
}

/**
 * Create a new server firewall rule
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.firewall.store', {server: serverId}).request(data)
        return response.data.data;
    } catch (e) {
        throw new Error('Can not store server firewall rule data.');
    }
}

/**
 * Load server firewall rule information by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function show(id) {
    try {
        const response = await api_route('v1.server.firewall.show', {rule: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load server firewall rule information.');
    }
}

/**
 * Delete server firewall rule by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function remove(id) {
    try {
        const response = await api_route('v1.server.firewall.delete', {rule: id}).request()
        return response.data;
    } catch (e) {
        throw new Error('Can not delete server firewall rule.');
    }
}