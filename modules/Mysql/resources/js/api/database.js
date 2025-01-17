import {api_route} from "@js/api/Router"
import {ApiRequestError} from "@js/errors"

/**
 * Load servers databases
 *
 * @param {String} serverId
 * @param {String} module
 * @return {Object}
 */
export async function list(serverId, module) {
    try {
        const response = await api_route('v1.server.databases', {server: serverId}).request({module})
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server databases.')
    }
}

/**
 * Create a new server database
 *
 * @param {String} serverId
 * @param {String} module
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, module, data) {
    data['module'] = module

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
export async function destroy(databaseId) {
    try {
        const response = await api_route('v1.server.database.delete', {database: databaseId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not delete server database.')
    }
}