import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors"

/**
 * Load servers modules
 *
 * @return {Object}
 */
export async function list() {
    try {
        const response = await api_route('v1.servers.modules').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load list of available modules.')
    }
}


/**
 * Load servers modules
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function installed(serverId, categories = []) {
    try {
        const response = await api_route('v1.server.modules', {server: serverId}).request({categories})
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server modules.')
    }
}


/**
 * Load servers modules
 *
 * @param {String} serverId
 * @param {Array} modules
 * @return {Object}
 */
export async function install(serverId, modules) {
    try {
        const response = await api_route('v1.server.modules.install', {server: serverId}).request(modules)
    } catch (e) {
       throw new ApiRequestError('Can not install modules.')
   }
}

