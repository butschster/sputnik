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
                <tr v-for="task in tasks">
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
        </div>
    </section>
</template>

<script>
    import StatusBadge from "@vue/components/UI/Badge/Status";

    export default {
        components: {StatusBadge},
        props: {
            server: Object
        },
        data() {
            return {
                tasks: [],
                loading: false
            }
        },
        mounted() {
            this.load()

            this.$echo.channel('server.' + this.server.id)
                .listen('.App\\Events\\Server\\Task\\Created', (e) => {
                    this.tasks.unshift(e.task)
                })
        },
        methods: {
            async load() {
                this.loading = true
                try {
                    const response = await this.$api('v1.server.tasks', {server: this.server.id}).request()
                    this.tasks = response.data.data
                } catch (e) {
                    console.error(e)
                }
                this.loading = false
            }
        }
    }
</script>