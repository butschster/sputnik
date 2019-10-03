import {api_route} from "@js/api/Router"
import {ApiRequestError} from "@js/errors"

/**
 * Load servers databases
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.databases', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server databases.')
    }
}

/**
 * Create a new server database
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.database.store', {server: serverId}).request(data)
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not store server database.')
    }
}

/**
 * Load server database information by ID
 *
 * @param {String} databaseId
 * @return {Object}
 */
export async function show(databaseId) {
    try {
        const response = await api_route('v1.server.database.show', {database: databaseId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server database information.')
    }
}

/**
 * Delete server database by ID
 *
 * @param {String} databaseId
 * @return {Object}
 */
export async function remove(databaseId) {
    try {
        const response = await api_route('v1.server.database.delete', {database: databaseId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not delete server database.')
    }
}