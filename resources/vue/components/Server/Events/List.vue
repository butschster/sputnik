<template>
    <section>
        <h4>Recent Events</h4>

        <div class="section-body">
            <Loader :loading="loading" />
            <table class="table">
                <col>
                <col width="200px">
                <tbody>
                <tr v-for="evt in events">
                    <th>{{ evt.message }}</th>
                    <td class="text-right">
                        <small class="badge">{{ evt.created_at }}</small>
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
                events: [],
                loading: false
            }
        },
        mounted() {
            this.load()

            this.$echo.channel('server.' + this.server.id)
                .listen('.App\\Events\\Server\\Event\\Created', (e) => {
                    this.events.unshift(e.event)
                })
        },
        methods: {
            async load() {
                this.loading = true
                try {
                    const response = await this.$api('v1.server.events', {server: this.server.id}).request()
                    this.events = response.data.data
                } catch (e) {
                    console.error(e)
                }
                this.loading = false
            }
        }
    }
</script>