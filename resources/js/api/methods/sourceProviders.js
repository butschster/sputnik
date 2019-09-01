import {api_route} from "../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load available source providers
 *
 * @return {Object}
 */
export async function list() {
    try {
        const response = await api_route('v1.source_providers').request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not list of available source providers.')
    }
}