import {api_route} from "@js/api/Router"
import {ApiRequestError} from "@js/errors"

/**
 * Load servers cron jobs
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.cron_jobs', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server cron jobs.')
    }
}

/**
 * Create a new server cron job
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.cron_job.store', {server: serverId}).request(data)
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not store server cron job.')
    }
}

/**
 * Load server cron job information by ID
 *
 * @param {String} jobId
 * @return {Object}
 */
export async function show(jobId) {
    try {
        const response = await api_route('v1.server.cron_job.show', {job: jobId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server cron job information.')
    }
}

/**
 * Delete server cron job by ID
 *
 * @param {String} jobId
 * @return {Object}
 */
export async function destroy(jobId) {
    try {
        const response = await api_route('v1.server.cron_job.delete', {job: jobId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not delete server cron job.')
    }
}