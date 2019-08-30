import Vue from 'vue'

Vue.prototype.$stripe = new Stripe(process.env.MIX_STRIPE_KEY)