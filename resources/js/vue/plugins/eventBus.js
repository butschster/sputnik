import Vue from 'vue'

const bus = new Vue()
Vue.$bus = Vue.prototype.$bus = bus