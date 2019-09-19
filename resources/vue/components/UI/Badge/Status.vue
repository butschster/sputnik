<template>
    <span v-if="status" class="badge" :class="statusClasses">
        {{ $t(`server.tasks.status.${status}`) }}
    </span>
</template>

<script>
    export default {
        props: {
            status: {
                type: String,
                default() {
                    return 'pending'
                }
            },
        },
        computed: {
            statusClasses() {
                switch (this.status.toLowerCase()) {
                    case 'timeout':
                        return 'badge-warning animated-progress'
                    case 'failed':
                        return 'badge-danger'
                    case 'running':
                        return 'badge-primary animated-progress'
                    case 'finished':
                        return 'badge-success'
                    case 'pending':
                        return 'animated-progress'
                }
            }
        }
    }
</script>
