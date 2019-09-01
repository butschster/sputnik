import {api_route} from "../../Router"
import {ApiRequestError} from "@js/errors";

/**
 * Load server tasks
 *
 * @param {String} serverId
 * @param {Number} page
 *
 * @return {Promise<any>}
 */
export async function list(serverId, page) {
    try {
        const response = await api_route('v1.server.tasks', {server: serverId}).request({page})
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not load server tasks.')
    }
}

/**
 * Load server task information by ID
 *
 * @param {String} taskId
 * @return {Promise<any>}
 */
export async function show(taskId) {
    try {
        const response = await api_route('v1.server.task.show', {task: taskId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server task information.')
    }
}