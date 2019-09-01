<template>
    <section>
        <h4>Recent Tasks</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <table class="table">
                <col>
                <col width="100px">
                <col width="150px">
                <thead>
                <tr>
                    <th>Task</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Time</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in tasks.data">
                    <th>
                        <router-link :to="{name: 'task.show', params: {id: task.id}}">
                            <strong>{{ task.name }}</strong>
                        </router-link>
                    </th>
                    <td class="text-right">
                        <StatusBadge :status="task.status"/>
                    </td>
                    <td class="text-right">
                        <small class="badge">{{ task.created_at | moment("from") }}</small>
                    </td>
                </tr>
                </tbody>
            </table>

            <Pagination :data="tasks" @pagination-change-page="load"/>
        </div>
    </section>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'
    import StatusBadge from "@vue/components/UI/Badge/Status";

    export default {
        components: {StatusBadge, Pagination},
        props: {
            server: Object
        },
        data() {
            return {
                tasks: {
                    data: []
                },
                loading: false
            }
        },
        mounted() {
            this.load()

            this.$echo.serverChannel(this.server.id)
                .listen('.App\\Events\\Server\\Task\\Created', (e) => {
                    this.tasks.data.unshift(e.task)
                })
        },
        methods: {
            async load(page = 1) {
                this.loading = true
                try {
                    this.tasks = await this.$api.serverTasks.list(this.server.id, page)
                } catch (e) {
                    console.error(e)
                }
                this.loading = false
            }
        }
    }
</script>