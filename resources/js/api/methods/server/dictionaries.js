import {api_route} from "@js/api";
import {ApiRequestError} from "@js/errors";

/**
 * Load php versions list
 *
 * @return {Object}
 */
export async function types() {
    try {
        const response = await api_route('v1.servers.dictionaries.types').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load server types list.')
    }
}

/**
 * Load php versions list
 *
 * @return {Object}
 */
export async function phpVersions() {
    try {
        const response = await api_route('v1.servers.dictionaries.php').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load php versions list.')
    }
}

/**
 * Load database types list
 *
 * @return {Object}
 */
export async function databaseTypes() {
    try {
        const response = await api_route('v1.servers.dictionaries.databases').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load database types list.')
    }
}

/**
 * Load webserver types list
 *
 * @return {Object}
 */
export async function webserverTypes() {
    try {
        const response = await api_route('v1.servers.dictionaries.webservers').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load webserver types list.')
    }
}
