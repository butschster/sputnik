import Vue from "vue";
import {api_route} from "./Router";
import api from "./api";


Vue.prototype.$api = api
Vue.prototype.$apiRoute = api_route

export {
    api_route,
    api
}