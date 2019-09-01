import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load servers list
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.users', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server users list.')
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
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not store server data.')
    }
}

/**
 * Load server user information by ID
 *
 * @param {String} userId
 * @return {Object}
 */
export async function show(userId) {
    try {
        const response = await api_route('v1.server.user.show', {user: userId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server user information.')
    }
}

/**
 * Delete server user by ID
 *
 * @param {String} userId
 * @return {Object}
 */
export async function remove(userId) {
    try {
        const response = await api_route('v1.server.user.delete', {user: userId}).request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete server user.')
    }
}