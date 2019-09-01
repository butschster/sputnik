import {api_route} from "../Router"
import {ApiRequestError} from "@js/errors"

/**
 * Get the recent notifications and announcements for the user.
 *
 * @return {Array}
 */
export async function list() {
    try {
        const response = await api_route('v1.profile.notifications').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load notifications.')
    }
}

/**
 *  Mark the given notifications as read.
 *
 * @param {Array} ids
 *
 * @return {Array}
 */
export async function markAsRead(ids) {
    try {
        const response = await api_route('v1.profile.notifications.read').request({ids})
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not mark notifications as read.')
    }
}