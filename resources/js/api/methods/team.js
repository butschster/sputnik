import {api_route} from "../Router"
import Vue from "vue"

/**
 * Load user team information by ID
 *
 * @param {String} id
 * @return {Object}
 */
export async function show(id) {
    try {
        const response = await api_route('v1.team.show', {team: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load team information.');
    }
}

/**
 * Load user team members
 *
 * @param {String} id
 *
 * @return {Object}
 */
export async function members(id) {
    try {
        const response = await api_route('v1.team.members', {team: id}).request()
        return response.data.data;
    } catch (e) {
        throw new Error('Can not load user team members.');
    }
}