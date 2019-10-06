<template>
    <div>
        <h1>
            {{ $t('scheduler.title') }}
        </h1>

        <CreateForm :server="$parent.server" @created="load" class="well well-lg mb-12"/>

        <div class="mt-10" v-if="hasJobs">
            <Loader :loading="loading"/>
            <h4>{{ $t('scheduler.jobs') }} ({{ jobs.length }})</h4>
            <table class="table mb-0">
                <col>
                <col width="100px">
                <col>
                <col width="80px">
                <col width="150px">
                <col width="100px">
                <col width="80px">
                <thead>
                <tr>
                    <th>{{ $t('scheduler.table.name') }}</th>
                    <th>{{ $t('scheduler.table.cron') }}</th>
                    <th>{{ $t('scheduler.table.command') }}</th>
                    <th class="text-right">{{ $t('scheduler.table.user') }}</th>
                    <th class="text-right">{{ $t('scheduler.table.next_run') }}</th>
                    <th class="text-right">{{ $t('scheduler.table.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="job in jobs" :key="job.id">
                    <th>{{ job.name }}</th>
                    <td>{{ job.cron }}</td>
                    <td>{{ job.command }}</td>
                    <td class="text-right">{{ job.user }}</td>
                    <td class="text-right">
                        <BadgeTimeFrom :date="job.next_run_at"/>
                    </td>
                    <td class="text-right">
                        <BadgeTaskStatus :task="job.task"/>
                    </td>

                    <td class="text-right">
                        <button class="btn btn-danger btn-circle btn-sm  btn-circle ml-auto" @click="destroy(job)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1418/1418561.svg" alt="" width="100px">
            <h3 class="mb-0">{{ $t('scheduler.message.empty_results') }}</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "./partials/CreateForm"

    export default {
        components: {CreateForm},
        data() {
            return {
                loading: false,
                jobs: [],
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.jobs = await this.$api.serverCron.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async destroy(job) {
                this.loading = true

                try {
                    await this.$api.serverCron.destroy(job.id)
                    this.onDestroy(job)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onDestroy(job) {
                this.load()
                this.$notify.success(this.$t('scheduler.message.deleted'))
            }
        },
        computed: {
            hasJobs() {
                return this.jobs.length > 0
            }
        }
    }
</script>
