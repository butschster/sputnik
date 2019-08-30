<template>
    <span class="badge" :class="statusClasses">{{ status }}</span>
</template>

<script>
    export default {
        props: {
            status: String
        },
        computed: {
            statusClasses() {
                switch (this.status.toLowerCase()) {
                    case 'failed':
                        return 'badge-error'
                    case 'running':
                        return 'badge-primary animated-progress'
                    case 'finished':
                        return 'badge-success'
                }


            }
        }
    }
</script>