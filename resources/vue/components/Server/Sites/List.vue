<template>
    <section class="servers-list">
        <loader :loading="loading"/>
        <div v-if="hasSites">
            <h4>Active domains ({{ sites.length }})</h4>
            <div class="servers-list-items">
                <ListItem v-for="site in sites" :key="site.id" :site="site" />
            </div>
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
    import ListItem from "@vue/components/Server/Sites/partials/ListItem"

    export default {
        components: {ListItem},
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

            this.$api.serverSites.onCreate(site => this.load())
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.sites = await this.$api.serverSites.list(this.$route.params.id)
                } catch (e) {
                    this.$handleError(e)
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
