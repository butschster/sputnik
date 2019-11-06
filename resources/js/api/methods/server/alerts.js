import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load server alerts
 *
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.alerts', {server: serverId}).request()
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load server alerts.')
    }
}