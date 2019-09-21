import {api_route} from "../../../Router"
import {ApiRequestError} from "@js/errors"

/**
 * Load OpenVPN clients list
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
   try {
        const response = await api_route('v1.server.openvpn.clients', {openvpn: serverId}).request()
        return response.data.data
    } catch (e) {
       throw new ApiRequestError('Can not load OpenVPN clients list.')
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
        const response = await api_route('v1.server.openvpn.client.store', {server: serverId}).request(data)
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not store OpenVPN client data.')
    }
}

/**
 * Delete server user by ID
 *
 * @param {String} clientId
 * @return {Object}
 */
export async function remove(clientId) {
    try {
        const response = await api_route('v1.server.openvpn.client.delete', {client: clientId}).request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete OpenVPN client.')
    }
}
