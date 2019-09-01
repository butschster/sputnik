import Vue from 'vue'
import {ApiRequestError} from "@js/errors";

const handleApiRequestErrors = (err) => {
    Vue.notify({
        type: 'error',
        text: err.message
    })
}

Vue.$handleError = Vue.prototype.$handleError = err => {

    if (err instanceof ApiRequestError) {
        handleApiRequestErrors(err)
    }

}