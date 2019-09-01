import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load servers supervisors
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.supervisors', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server supervisors.')
    }
}

/**
 * Create a new server supervisor
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.supervisor.store', {server: serverId}).request(data)
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not store server supervisor.')
    }
}

/**
 * Load server supervisor information by ID
 *
 * @param {String} supervisorId
 * @return {Object}
 */
export async function show(supervisorId) {
    try {
        const response = await api_route('v1.server.supervisor.show', {supervisor: supervisorId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server supervisor information.')
    }
}

/**
 * Delete server supervisor by ID
 *
 * @param {String} supervisorId
 * @return {Object}
 */
export async function remove(supervisorId) {
    try {
        const response = await api_route('v1.server.database.delete', {supervisor: supervisorId}).request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete server supervisor.')
    }
}