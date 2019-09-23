<template>
    <section>
        <h4>{{ $t('server.tasks.recent') }}</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <DynamicTable :data="tasks.data" :structure="tableStructure" />

            <table class="table" v-if="hasTasks">
                <col>
                <col width="100px">
                <col width="150px">
                <thead>
                <tr>
                    <th>{{ $t('server.tasks.table.name') }}</th>
                    <th class="text-right">{{ $t('server.tasks.table.status') }}</th>
                    <th class="text-right">{{ $t('server.tasks.table.time') }}</th>
                </tr>
                </thead>
                <tbody>
                <ListItem v-for="task in tasks.data" :key="task.id" :task="task"/>
                </tbody>
            </table>
            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681318.svg"
                     width="150px">
                <h3 class="mb-0">{{ $t('server.tasks.message.empty_results') }}</h3>
            </div>

            <Pagination :data="tasks" @pagination-change-page="load"/>
        </div>
    </section>
</template>

<script>
    import Table from "@vue/components/UI/Table/Table"
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
                tableStructure: {
                    name: {
                        type: 'string',
                        title: 'server.tasks.table.name',
                        headClasses: null,
                        classes: null,
                        width: null,
                        tag: 'th'
                    },
                    status: {
                        type: 'task.status',
                        title: 'server.tasks.table.status',
                        headClasses: ['text-right'],
                        width: '100px'
                    },
                    time: {
                        type: 'time',
                        title: 'server.tasks.table.time',
                        headClasses: ['text-right'],
                        width: '150px'
                    }
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
