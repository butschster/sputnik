<template>
        <section class="w-full">
            <div class="container pl-10">
                <h4>Recent Tasks</h4>

                <div class="section-body">
                    <Loader :loading="loading"/>
                    <table class="table" v-if="hasTasks">
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
                        <ListItem v-for="task in tasks.data" :key="task.id" :task="task"/>
                        </tbody>
                    </table>
                    <div v-else class="well well-lg text-center">
                        <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681318.svg" alt=""
                             width="150px">
                        <h3 class="mb-0">Looks like you don't have any executed tasks yet</h3>
                    </div>

                    <Pagination :data="tasks" @pagination-change-page="load"/>
                </div>
            </div>
        </section>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'
    import ListItem from "@vue/components/Server/Tasks/ListItem"

    export default {
        components: {ListItem, Pagination},
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

            this.$echo.onServerTaskCreated(this.server.id, (e) => {
                this.tasks.data.unshift(e.task)
            })
        },
        methods: {
            async load(page = 1) {
                this.loading = true
                try {
                    this.tasks = await this.$api.serverTasks.list(this.server.id, page)
                } catch (e) {
                    this.$handleError(e)
                }
                this.loading = false
            }
        },
        computed: {
            hasTasks() {
                return this.tasks.data.length > 0
            }
        },
    }
</script>
