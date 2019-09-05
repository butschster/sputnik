export default {
    computed: {
        canBeManaged() {
            return this.isSupported && this.isSupported
        },
        isPending() {
            return this.server.status == 'pending'
        },
        isConfiguring() {
            return this.server.status == 'configuring'
        },
        isConfigured() {
            return this.server.status == 'configured'
        },
        hasSysInfo() {
            return this.server.hasOwnProperty('sys_info')
        },
        isSupported() {

            if (this.hasSysInfo) {
                return this.server.sys_info.is_supported
            }

            return true
        }
    },
}