import Vue from "vue";
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import listeners from '../../broadcast'

Object.keys(listeners).forEach((module) => {
    const functions = listeners[module]

    Object.keys(functions).forEach(listener => {
        Echo.prototype[listener] = functions[listener]
    })

})

Vue.prototype.$echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
