<template>
    <section>
        <h4>Server tasks</h4>

        <div class="section-body">
            <Loader :loading="loading" />
            <table class="table">
                <col>
                <col width="100px">
                <col width="150px">
                <tbody>
                <tr v-for="task in tasks">
                    <th>
                        <router-link :to="{name: 'task.show', params: {id: task.id}}">
                            <strong>{{ task.name }}</strong>
                        </router-link>
                    </th>
                    <td class="text-right">
                        <span class="badge badge-dark">{{ task.status }}</span>
                    </td>
                    <td class="text-right">
                        <small class="badge">{{ task.created_at }}</small>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script>
    export default {
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