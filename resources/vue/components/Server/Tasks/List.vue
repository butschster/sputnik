<template>
    <section>
        <h4>{{ $t('server.tasks.recent') }}</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <div class="divTable" style="width: 100%;" v-if="hasTasks">
                <div class="divTableHeading">
                    <div class="divTableRow">
                        <div class="divTableCell">&nbsp;</div>
                        <div class="divTableCell">{{ $t('server.tasks.table.name') }}</div>
                        <div class="divTableCell">{{ $t('server.tasks.table.time') }}</div>
                    </div>
                </div>
                <div class="divTableBody">

                    <ListItem v-for="task in tasks.data" :key="task.id" :task="task"/>

                </div>
            </div>
            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681318.svg"
                     width="150px">-->
                <h3 class="mb-0">{{ $t('server.tasks.message.empty_results') }}</h3>
            </div>
            <Pagination :data="tasks" @pagination-change-page="load"/>
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
