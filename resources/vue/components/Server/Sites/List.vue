<template>
    <section class="servers-list">
        <loader :loading="loading"/>
        <h4>Active domains ({{ sites.length }})</h4>
        <div class="servers-list-items" v-if="hasSites">
            <router-link :to="{name: 'site.show', params: {id: site.id }}" class="servers-list-item-wrapper" v-for="site in sites" :key="site.id">
                <div class="servers-list-item__name ml-5 font-medium">
                    {{ site.domain }}
                </div>
            </router-link>
        </div>
        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10"
                 src="https://image.flaticon.com/icons/svg/1908/1908731.svg"
                 alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any sites :(</h3>
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
                loading: false,
                sites: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.server.sites', {server: this.$route.params.id}).request()
                    this.sites = response.data.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasSites() {
                return this.sites.length > 0
            }
        }
    }
</script>
