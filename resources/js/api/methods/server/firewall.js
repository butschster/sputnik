import {api_route} from "../../Router"

/**
 * Load servers firewall rules
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.firewall.rules', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new Error('Can not load server firewall rules list.')
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
        return response.data.data
    } catch (e) {
        throw new Error('Can not store server firewall rule data.')
    }
}

/**
 * Load server firewall rule information by ID
 *
 * @param {String} ruleId
 * @return {Object}
 */
export async function show(ruleId) {
    try {
        const response = await api_route('v1.server.firewall.show', {rule: ruleId}).request()
        return response.data.data
    } catch (e) {
        throw new Error('Can not load server firewall rule information.')
    }
}

/**
 * Delete server firewall rule by ID
 *
 * @param {String} ruleId
 * @return {Object}
 */
export async function remove(ruleId) {
    try {
        const response = await api_route('v1.server.firewall.delete', {rule: ruleId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not delete server firewall rule.')
    }
}