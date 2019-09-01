import {api_route} from "../../Router";

/**
 * Load server tasks
 *
 * @param {String} id
 * @param {Number} page
 *
 * @return {Promise<any>}
 */
export async function list(id, page) {
    try {
        const response = await api_route('v1.server.tasks', {server: id}).request({page})
        return response.data;
    } catch (e) {
        throw new Error('Can not load server tasks.');
    }
}

/**
 * Load server task information by ID
 *
 * @param {String} id
 * @return {Promise<any>}
 */
export async function show(id) {
    try {
        const response = await api_route('v1.server.task.show', {task: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load server task information.');
    }
}

/**
 * Delete server task by ID
 *
 * @param {String} id
 * @return {Promise<void>}
 */
export async function remove(id) {
    try {
        const response = await api_route('v1.server.task.delete', {task: id}).request()
        return response.data;
    } catch (e) {
        throw new Error('Can not delete server task.');
    }
}