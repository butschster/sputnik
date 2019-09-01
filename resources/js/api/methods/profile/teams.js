import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load user teams
 *
 * @return {Object}
 */
export async function list() {
    try {
        const response = await api_route('v1.profile.teams').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load user teams.')
    }
}