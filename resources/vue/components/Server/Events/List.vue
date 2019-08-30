<template>
    <section>
        <h4>Recent Events</h4>

        <div class="section-body">
            <Loader :loading="loading"/>
            <table class="table">
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
                events: [],
                loading: false
            }
        },
        mounted() {
            this.load()

            this.$echo.channel('server.' + this.server.id)
                .listen('.App\\Events\\Server\\Event\\Created', (e) => {
                    this.events.data.unshift(e.event)
                })
        },
        methods: {
            async load(page = 1) {
                this.loading = true
                try {
                    const response = await this.$api('v1.server.events', {server: this.server.id}).request({page})
                    this.events = response.data
                } catch (e) {
                    console.error(e)
                }
                this.loading = false
            }
        }
    }
</script>