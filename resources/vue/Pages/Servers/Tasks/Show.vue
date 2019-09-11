<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="task">
            <h3>{{ task.name }}</h3>

            <table class="table">
                <tbody>
                <tr>
                    <th>User</th>
                    <td>{{ task.user }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <BadgeTaskStatus :task="task"/>
                    </td>
                </tr>
                <tr>
                    <th>Success</th>
                    <td>{{ task.is_successful ? 'Yes' : 'No' }}</td>
                </tr>
                </tbody>
            </table>

            <section class="section mt-10" v-if="task.script">
                <div class="section-header">Command</div>

                <pre class="break-all">{{ task.script }}</pre>
            </section>

            <section class="section mt-10" v-if="task.output">
                <div class="section-header">Output</div>

                <pre class="break-all">{{ task.output }}</pre>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                task: null,
                loading: false,
            }
        },
        created() {
            this.load()
        },
        methods: {
            loaded() {
                this.$echo.onServerTaskStatusChanged(this.task.server_id, (e) => {
                    this.load()
                })
            },
            async load() {
                this.loading = true

                try {
                    this.task = await this.$api.serverTasks.show(this.$route.params.task_id)
                    this.loaded()
                } catch (e) {
                    this.$handleError(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
        watch: {
            '$route': 'load'
        }
    }
</script>