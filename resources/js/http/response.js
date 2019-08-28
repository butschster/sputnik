import axios from "axios";
import Vue from 'vue'
import {ErrorBag} from "vee-validate";
import {forEach} from "lodash";
import store from "@js/vue/store";

axios.interceptors.response.use(response => response, error => {

    switch (error.response.status) {
        case 403:
            console.log(error.response)
            Vue.notify({
                type: 'warn',
                title: 'Access denied',
                text: error.response.data.message
            })
            break
        case 422:
            const bag = new ErrorBag()
            forEach(error.response.data.errors, (errors, field) => {
                forEach(errors, msg => {
                    bag.add({
                        field: field,
                        msg,
                        scope: error.response.data.bag,
                    })
                })
            })

            store.dispatch('validation/setErrors', bag)
            break
    }

    return Promise.reject(error)
})
