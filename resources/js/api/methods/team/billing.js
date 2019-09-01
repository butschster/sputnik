import {api_route} from "../../Router"
import Vue from "vue"

const PAYMENT_METHOD_STORED = 'team.payment_method.stored'
const PAYMENT_METHOD_DELETED = 'team.payment_method.deleted'

/**
 * Load payment methods
 *
 * @param {String} id
 * @return {Object}
 */
export async function paymentMethods(id) {
    try {
        const response = await api_route('v1.team.payment.methods', {team: id}).request()
        return response.data;
    } catch (e) {
        throw new Error('Can not load payment methods.');
    }
}

/**
 * Store payment method
 *
 * @param {String} id
 * @return String
 */
export async function createIntentionSecret(id) {
    try {
        const response = await api_route('v1.team.payment.method.intent', {team: id}).request()
        return response.data;
    } catch (e) {
        throw new Error('Can not load payment methods.');
    }
}

/**
 * Store payment method
 *
 * @param {String} id
 * @param {Object} intention
 * @return {Object}
 */
export async function storePaymentMethod(id, intention) {
    try {
        const response = await api_route('v1.team.payment.method.store', {team: id}).request(intention)
        Vue.$bus.$emit(PAYMENT_METHOD_STORED, response.data)

        return response.data;
    } catch (e) {
        throw new Error('Can not load payment methods.');
    }
}

/**
 *
 * @param {Function} callback
 */
export function ocPaymentMethodStore(callback) {
    Vue.$bus.$on(PAYMENT_METHOD_STORED, callback)
}

/**
 * Delete payment method
 *
 * @param {String} id Team ID
 * @param {String} methodId Payment method ID
 * @return {Object}
 */
export async function deletePaymentMethod(id, methodId) {
    try {
        const response = await api_route('v1.team.payment.method.delete', {team: id, id: methodId}).request()

        Vue.$bus.$emit(PAYMENT_METHOD_DELETED, {id, methodId})

        return response.data;
    } catch (e) {
        throw new Error('Can not delete payment method.');
    }
}

/**
 *
 * @param {Function} callback
 */
export function ocPaymentMethodDelete(callback) {
    Vue.$bus.$on(PAYMENT_METHOD_DELETED, callback)
}
