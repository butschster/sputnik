import Vue from 'vue'

let event = new Vue()
Vue.prototype.$dropdown = {
    event,
    show(modal) {
        setTimeout(() => {
            event.$emit('show', modal)
        }, 100)
    },
    close(modal) {
        event.$emit('close', modal)
    },
    closeAll() {
        event.$emit('close-all')
    }
}
