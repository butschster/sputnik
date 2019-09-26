import Vue from 'vue'
import notify from "@js/vue/plugins/notify"
import {ApiRequestError} from "@js/errors";

const handleApiRequestErrors = (err) => {
    console.error(err.message)
    //notify.error(err.message)
}

Vue.$handleError = Vue.prototype.$handleError = err => {

    if (err instanceof ApiRequestError) {
        handleApiRequestErrors(err)
    }

}
