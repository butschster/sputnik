<template>
    <section>
        <h4>Recent Events</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <table class="table" v-if="hasEvents">
                <col>
                <col width="200px">
                <thead>
                <tr>
                    <th>Event</th>
                    <th class="text-right">Time</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="evt in events.data" :key="evt.id">
                    <th>{{ evt.message }}</th>
                    <td class="text-right">
                        <small class="badge">{{ evt.created_at | moment("from") }}</small>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1421/1421313.svg" alt="" width="150px">
                <h3 class="mb-0">Looks like you don't have any events yet</h3>
            </div>

            <Pagination :data="events" @pagination-change-page="load" />
        </div>
    </section>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'

    export default {
        components: {Pagination},
        props: {
            server: Object
        },
        data() {
            return {
                events: {
                    data: []
                },
                loading: false
            }
        },
        mounted() {
            this.load()

            this.$echo.onServerEventCreated(this.server.id, (e) => {
                this.events.data.unshift(e.event)
            })
        },
        computed: {
            hasEvents() {
                return this.events.data.length > 0
            }
        },
        methods: {
            async load(page = 1) {
                this.loading = true
                try {
                    this.events = await this.$api.serverEvents.list(this.server.id, page)
                } catch (e) {
                    this.$handleError(e)
                }
                this.loading = false
            }
        }
    }
</script>