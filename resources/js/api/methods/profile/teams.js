import {api_route} from "../../Router"

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
        throw new Error('Can not load user teams.')
    }
}