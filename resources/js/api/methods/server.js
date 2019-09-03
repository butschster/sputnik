import {api_route} from "../Router"
import Vue from "vue"
import {ApiRequestError, ApiResponseError} from "@js/errors";

const SERVER_CREATED = 'server.created'
const SERVER_UPDATED = 'server.updated'
const SERVER_DELETED = 'server.deleted'

/**
 * Load servers list
 *
 * @return {Array}
 */
export async function list() {
    try {
        const response = await api_route('v1.servers').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load servers list.')
    }
}

/**
 * Search by servers
 *
 * @return {Array}
 */
export async function search(query) {
    try {
        const response = await api_route('v1.servers.search').request({query})
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not search servers.')
    }
}

/**
 * Load server information by ID
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function show(serverId) {
    try {
        const response = await api_route('v1.server.show', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server information.')
    }
}

/**
 * Create a new server
 *
 * @param {Object} data
 * @return {Object}
 */
export async function store(data) {
    try {
        const response = await api_route('v1.server.store').request(data)

        const server = response.data.data
        Vue.$bus.$emit(SERVER_CREATED, server)

        return server
    } catch (e) {
        throw new ApiRequestError('Can not store server data.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onCreate(callback) {
    Vue.$bus.$on(SERVER_CREATED, callback)
}

/**
 * Update server data by ID
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function update(serverId, data) {
   try {
        const response = await api_route('v1.server.update', {server: serverId}).request(data)

        const server = response.data.data
        Vue.$bus.$emit(SERVER_UPDATED, server)

        return server
   } catch (e) {
       throw new ApiRequestError('Can not update server information.')
   }
}

/**
 *
 * @param {Function} callback
 */
export function onUpdate(callback) {
    Vue.$bus.$on(SERVER_UPDATED, callback)
}

/**
 * Delete server by ID
 *
 * @param {String} serverId
 * @return {Object}
 */
export async function remove(serverId) {
    try {
        const response = await api_route('v1.server.delete', {server: serverId}).request()
        Vue.$bus.$emit(SERVER_DELETED, serverId)
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete server.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onDelete(callback) {
    Vue.$bus.$on(SERVER_DELETED, callback)
}