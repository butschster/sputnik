<template>
    <span v-if="hasTask" class="badge" :class="statusClasses" @dblclick="load">{{ current_task.status }}</span>
</template>

<script>
    export default {
        props: {
            task: Object,
        },
        data() {
            return {
                current_task: {
                    server_id: null,
                    status: 'pending'
                },
                loading: false
            }
        },
        watch: {
            task(task) {
                if (task) {
                    this.current_task = task
                }
            }
        },
        mounted() {
            if (this.hasTask) {
                this.current_task = this.task
            }

            if (this.current_task) {
                this.$echo.onServerTaskStatusChanged(this.current_task.server_id, (e) => {
                    if (e.task.id == this.current_task.id) {
                        this.current_task = e.task
                    }
                })
            }
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.current_task = await this.$api.serverTasks.show(this.current_task.id)
                } catch (e) {
                   this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasTask() {
                return typeof this.task === 'object' && this.task !== null
            },
            statusClasses() {
                if (this.loading) {
                    return 'animated-progress'
                }

                switch (this.current_task.status.toLowerCase()) {
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
