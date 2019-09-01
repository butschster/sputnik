import {api_route} from "../Router";
import Vue from "vue";

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
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load servers list.');
    }
}

/**
 * Load server information by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function show(id) {
    try {
        const response = await api_route('v1.server.show', {server: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load server information.');
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
        throw new Error('Can not store server data.');
    }
}

/**
 *
 * @param {Function} callback
 */
export function ocCreate(callback) {
    Vue.$bus.$on(SERVER_CREATED, callback)
}

/**
 * Update server data by ID
 *
 * @param {String} id
 * @param {Object} data
 * @return {Object}
 */
export async function update(id, data) {
   // try {
        const response = await api_route('v1.server.update', {server: id}).request(data)

        const server = response.data.data
        Vue.$bus.$emit(SERVER_UPDATED, server)

        return server;
   // } catch (e) {
   //     throw new Error('Can not update server information.');
   // }
}

/**
 *
 * @param {Function} callback
 */
export function ocUpdate(callback) {
    Vue.$bus.$on(SERVER_UPDATED, callback)
}

/**
 * Delete server by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function remove(id) {
    try {
        const response = await api_route('v1.server.delete', {server: id}).request()
        Vue.$bus.$emit(SERVER_DELETED, id)
        return response.data;
    } catch (e) {
        throw new Error('Can not delete server.');
    }
}

/**
 *
 * @param {Function} callback
 */
export function ocDelete(callback) {
    Vue.$bus.$on(SERVER_DELETED, callback)
}