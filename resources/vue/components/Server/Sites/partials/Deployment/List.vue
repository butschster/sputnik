<template>
    <section>
        <h4>Recent Deployemnts</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <table class="table" v-if="hasDeployemnts">
                <col>
                <col width="150px">
                <col width="150px">
                <thead>
                <tr>
                    <th>Time</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Task</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="deployment in deployments.data">
                    <td>
                        <BadgeTimeFrom :date="deployment.created_at" />
                    </td>
                    <td class="text-right">
                        <BadgeStatus :status="deployment.status" />
                    </td>
                    <td class="text-right">
                        <BadgeTaskStatus :task="deployment.task" />
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681318.svg" alt="" width="150px">
                <h3 class="mb-0">Looks like you don't have any deployments yet</h3>
            </div>

            <Pagination :data="deployments" @pagination-change-page="load"/>
        </div>
    </section>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'
    export default {
        components: {Pagination},
        props: {
            site: Object
        },
        data() {
            return {
                loading: false,
                deployments: {
                    data: []
                },
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load(page = 1) {
                this.loading = true

                try {
                    this.deployments = await this.$api.serverSiteDeployment.list(this.site.id, page)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasDeployemnts() {
                return this.deployments.data.length > 0
            }
        }
    }
</script>