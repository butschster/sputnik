import {api_route} from "../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load user team information by ID
 *
 * @param {String} teamId
 * @return {Object}
 */
export async function show(teamId) {
    try {
        const response = await api_route('v1.team.show', {team: teamId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load team information.')
    }
}

/**
 * Update user team information
 *
 * @param {String} teamId
 * @param {Object} data
 * @return {Object}
 */
export async function update(teamId, data) {
    try {
        const response = await api_route('v1.team.update', {team: teamId}).request(data)
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not update team information.')
    }
}

/**
 * Load user team members
 *
 * @param {String} teamId
 *
 * @return {Object}
 */
export async function members(teamId) {
    try {
        const response = await api_route('v1.team.members', {team: teamId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load user team members.')
    }
}