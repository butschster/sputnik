import {api_route} from "../Router"

/**
 * Load available source providers
 *
 * @return {Object}
 */
export async function list() {
    try {
        const response = await api_route('v1.source_providers').request()
        return response.data;
    } catch (e) {
        throw new Error('Can not list of available source providers.');
    }
}