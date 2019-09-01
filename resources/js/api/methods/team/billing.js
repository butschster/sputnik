import {api_route} from "../../Router"
import Vue from "vue"

const PAYMENT_METHOD_STORED = 'team.payment_method.stored'
const PAYMENT_METHOD_DELETED = 'team.payment_method.deleted'

/**
 * Load payment methods
 *
 * @param {String} teamId
 * @return {Object}
 */
export async function paymentMethods(teamId) {
    try {
        const response = await api_route('v1.team.payment.methods', {team: teamId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not load payment methods.')
    }
}

/**
 * Store payment method
 *
 * @param {String} teamId
 * @return String
 */
export async function createIntentionSecret(teamId) {
    try {
        const response = await api_route('v1.team.payment.method.intent', {team: teamId}).request()
        return response.data
    } catch (e) {
        throw new Error('Can not load payment methods.')
    }
}

/**
 * Store payment method
 *
 * @param {String} teamId
 * @param {Object} intention
 * @return {Object}
 */
export async function storePaymentMethod(teamId, intention) {
    try {
        const response = await api_route('v1.team.payment.method.store', {team: teamId}).request(intention)
        Vue.$bus.$emit(PAYMENT_METHOD_STORED, response.data)

        return response.data
    } catch (e) {
        throw new Error('Can not load payment methods.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onPaymentMethodStore(callback) {
    Vue.$bus.$on(PAYMENT_METHOD_STORED, callback)
}

/**
 * Delete payment method
 *
 * @param {String} teamId Team ID
 * @param {String} methodId Payment method ID
 * @return {Object}
 */
export async function deletePaymentMethod(teamId, methodId) {
    try {
        const response = await api_route('v1.team.payment.method.delete', {team: teamId, id: methodId}).request()

        Vue.$bus.$emit(PAYMENT_METHOD_DELETED, {id, methodId})

        return response.data
    } catch (e) {
        throw new Error('Can not delete payment method.')
    }
}

/**
 *
 * @param {Function} callback
 */
export function onPaymentMethodDelete(callback) {
    Vue.$bus.$on(PAYMENT_METHOD_DELETED, callback)
}
