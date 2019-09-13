import {api_route} from "../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load sites list
 *
 * @return {Object}
 */
export async function list() {
    try {
        const response = await api_route('v1.sites').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load sites.')
    }
}
