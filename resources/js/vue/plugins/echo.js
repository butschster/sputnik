import Vue from "vue";
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

Echo.prototype.serverChannel = function(serverId) {
    return this.private('server.' + serverId)
}

Vue.prototype.$echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
