<template>
    <span v-if="status" class="badge" :class="statusClasses">{{ status }}</span>
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
