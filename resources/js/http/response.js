import axios from "axios";
import {ErrorBag} from "vee-validate";
import {forEach} from "lodash";
import store from "@js/store";

axios.interceptors.response.use(response => response, error => {

    switch (error.response.status) {
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