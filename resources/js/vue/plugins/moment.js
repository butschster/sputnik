import Vue from 'vue'
import VueMoment from 'vue-moment'

const moment = require('moment')
require('moment/locale/ru')

moment.locale(window.user.lang)

Vue.use(VueMoment, {moment})
