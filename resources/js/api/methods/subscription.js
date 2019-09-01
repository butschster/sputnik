import {api_route} from "../Router"
import Vue from "vue"
import {ApiRequestError} from "@js/errors";

const TEAM_SUBSCRIBED_TO_PLAN = 'team.subscribed'
const TEAM_SUBSCRIPTION_CANCELED = 'team.subscribtion.canceled'
const TEAM_SUBSCRIPTION_RESUMED = 'team.subscribtion.resumed'

/**
 * Load subscription plans
 *
 * @return {Array}
 */
export async function plans() {
    try {
        const response = await api_route('v1.subscription.plans').request()
        return response.data.data
    } catch (e) {
        throw new ApiRequestError('Can not load subscription plans list.')
    }
}

/**
 * Subscribe team to plan
 *
 * @param {String} teamId
 * @param {String} PlanId
 * @return {Promise<*>}
 */
export async function subscribe(teamId, PlanId) {
    try {
        await api_route('v1.team.subscribe', {team: teamId, plan: PlanId}).request()

        Vue.$bus.$emit(TEAM_SUBSCRIBED_TO_PLAN)
    } catch (e) {
        throw new ApiRequestError('Can not subscribe team to plan.')
    }
}

/**
 *  Subscribe to subscribe event
 *
 * @param {Function} callback
 */
export function onSubscribe(callback) {
    Vue.$bus.$on(TEAM_SUBSCRIBED_TO_PLAN, callback)
}


/**
 * Subscribe team to plan
 *
 * @param {String} teamId
 * @return {Promise<*>}
 */
export async function cancel(teamId) {
    try {
        await api_route('v1.team.subscription.cancel', {team: teamId}).request()

        Vue.$bus.$emit(TEAM_SUBSCRIPTION_CANCELED)
    } catch (e) {
        throw new ApiRequestError('Can not cancel team subscription.')
    }
}

/**
 *  Subscribe to cancel event
 *
 * @param {Function} callback
 */
export function onCancel(callback) {
    Vue.$bus.$on(TEAM_SUBSCRIPTION_CANCELED, callback)
}


/**
 * Subscribe team to plan
 *
 * @param {String} teamId
 * @return {Promise<*>}
 */
export async function resume(teamId) {
    try {
        await api_route('v1.team.subscription.resume', {team: teamId}).request()

        Vue.$bus.$emit(TEAM_SUBSCRIPTION_RESUMED)
    } catch (e) {
        throw new ApiRequestError('Can not resume team subscription.')
    }
}

/**
 *  Subscribe to resume event
 *
 * @param {Function} callback
 */
export function onResume(callback) {
    Vue.$bus.$on(TEAM_SUBSCRIPTION_RESUMED, callback)
}
