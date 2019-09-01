import {api_route} from "../Router"
import Vue from "vue"
import {ApiRequestError} from "@js/errors";

const PROFILE_DELETED = 'user.profile.deleted'
const PROFILE_UPDATED = 'user.profile.updated'

/**
 * Load current user profile
 *
 * @return {Object}
 */
export async function profile() {
    try {
        const response = await api_route('v1.user.profile').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load user profile.')
    }
}

/**
 * Update current user profile
 *
 * @return {Object}
 */
export async function update(data) {
    try {
        const response = await api_route('v1.user.profile.update').request(data)
        const user = response.data.data
        Vue.$bus.$emit(PROFILE_UPDATED, user)
        return user
    } catch (e) {
        throw new ApiRequestError('Can not update user profile.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onUpdate(callback) {
    Vue.$bus.$on(PROFILE_UPDATED, callback)
}

/**
 * Load profile source providers
 *
 * @return {Object}
 */
export async function sourceProviders() {
    try {
        const response = await api_route('v1.profile.source_providers').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load profile source providers.')
    }
}

/**
 * Delete profile
 *
 * @param {Object} data
 * @return {Object}
 */
export async function remove(data) {
    try {
        const response = await api_route('v1.profile.delete').request(data)
        Vue.$bus.$emit(PROFILE_DELETED)
        return response.data
    } catch (e) {
        throw new ApiRequestError('Can not delete profile.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onDelete(callback) {
    Vue.$bus.$on(PROFILE_DELETED, callback)
}