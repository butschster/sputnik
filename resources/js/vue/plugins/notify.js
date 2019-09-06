import Noty from 'noty'
import Vue from 'vue'

const notify = {

    /**
     * @param {String} text
     * @returns {*}
     */
    success(text) {
        return this.message(text, "success")
    },

    /**
     * @param {String} text
     * @returns {*}
     */
    info(text) {
        return this.message(text, "info")
    },

    /**
     * @param {String} text текст
     * @returns {*}
     */
    error(text) {
        return this.message(text, "error")
    },

    /**
     * @param {String} text
     * @returns {*}
     */
    warning(text) {
        return this.message(text, 'warning')
    },

    /**
     * @param {String} text
     * @returns {*}
     */
    alert(text) {
        return this.message(text, 'alert')
    },

    /**
     * @param {String} text
     * @param {String} type
     * @returns {*}
     */
    message(text, type) {
        return new Noty({type, text, theme: 'mint'}).show();
    },

    /**
     * @param {String} message текст
     * @return Promise
     */
    confirm(message) {
        return new Promise((resolve, reject) => {
            new Noty({
                text: message,
                buttons: [
                    Noty.button('YES', 'btn btn-success', function () {
                        resolve()
                    }, {id: 'button1', 'data-status': 'ok'}),

                    Noty.button('NO', 'btn btn-error', function () {
                        reject()
                        n.close()
                    })
                ]
            }).show()
        })
    }
}

Vue.prototype.$notify = notify

export default notify