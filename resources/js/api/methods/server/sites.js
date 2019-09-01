import {api_route} from "../../Router"
import Vue from "vue"
import {ApiRequestError} from "@js/errors";

const SITE_CREATED = 'server.site.created'
const SITE_DELETED = 'server.site.deleted'

/**
 * Load server sites
 *
 * @param {String} serverId
 *
 * @return {Object}
 */
export async function list(serverId) {
    try {
        const response = await api_route('v1.server.sites', {server: serverId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server sites.')
    }
}

/**
 * Load server task information by ID
 *
 * @param {String} siteId
 * @return {Promise<any>}
 */
export async function show(siteId) {
    try {
        const response = await api_route('v1.server.site.show', {site: siteId}).request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load server site information.')
    }
}

/**
 * Create a new server site
 *
 * @param {String} serverId
 * @param {Object} data
 * @return {Object}
 */
export async function store(serverId, data) {
    try {
        const response = await api_route('v1.server.site.store', {server: serverId}).request(data)

        const site = response.data.data
        Vue.$bus.$emit(SITE_CREATED, site)

        return site
    } catch (e) {
        throw new ApiRequestError('Can not store server site data.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onCreate(callback) {
    Vue.$bus.$on(SITE_CREATED, callback)
}

/**
 * Delete server site by ID
 *
 * @param {String} siteId
 * @return {Promise<void>}
 */
export async function remove(siteId) {
    try {
        const response = await api_route('v1.server.site.delete', {site: siteId}).request()
        Vue.$bus.$emit(SITE_DELETED, siteId)
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete server task.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onDelete(callback) {
    Vue.$bus.$on(SITE_DELETED, callback)
}