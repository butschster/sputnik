<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="task">
            <h3>{{ task.name }}</h3>

            <table class="table">
                <tbody>
                <tr>
                    <th>{{ $t('server.tasks.item.user') }}</th>
                    <td>{{ task.user }}</td>
                </tr>
                <tr>
                    <th>{{ $t('server.tasks.item.status') }}</th>
                    <td>
                        <BadgeTaskStatus :task="task"/>
                    </td>
                </tr>
                <tr>
                    <th>{{ $t('server.tasks.item.success') }}</th>
                    <td>
                        <span class="badge" :class="{'badge-success' : task.is_successful, 'badge-danger': !task.is_successful}">
                            <strong>[{{ task.exit_code }}]</strong> {{ task.exit_code_text }}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>

            <section class="section mt-10" v-if="task.script">
                <div class="section-header">{{ $t('server.tasks.item.script') }}</div>

                <PrismEditor :code="task.script" language="bash" lineNumbers readonly class="break-all" />
            </section>

            <section class="section mt-10" v-if="task.output">
                <div class="section-header">{{ $t('server.tasks.item.output') }}</div>

                <PrismEditor :code="task.output" language="bash" lineNumbers readonly class="break-all" />
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

            this.$bus.$on(`task.${this.$route.params.task_id}`, (task) => {
                this.load()
            })
        },
        methods: {
            loaded() {

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
