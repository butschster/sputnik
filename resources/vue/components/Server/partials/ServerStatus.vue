<template>
    <div class="servers-list-item__status">
        <i class="icon fas" :class="icon"></i>
        <div class="status-indicator" :class="server.status"></div>
    </div>
</template>

<script>
    export default {
        props: {
            server: Object
        },
        computed: {
            icon() {
                switch (this.server.type) {
                    case 'openvpn':
                        return 'fa-random'
                }

                return 'fa-server'
            }
        }
    }
</script>
