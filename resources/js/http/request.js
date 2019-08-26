import axios from "axios";
import store from "@js/vue/store";

axios.interceptors.request.use((config) => {
    store.dispatch('validation/clear')

    // Do something before request is sent
    const token = store.getters['auth/token']

    if (token) {
        config.headers.common['Authorization'] = `Bearer ${token}`
    }

    return config
}, error => {
    return Promise.reject(error)
})
