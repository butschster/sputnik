import {api_route} from "../../Router";

/**
 * Load user teams
 *
 * @param {String} id
 * @param {Number} page
 *
 * @return {Object}
 */
export async function list(id, page) {
    try {
        const response = await api_route('v1.profile.teams').request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load user teams.');
    }
}