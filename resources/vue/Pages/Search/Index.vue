<template>
    <div class="flex justify-between w-12">
        <loader :loading="loading"/>
        <ul>
          <li v-for ="resultsServer in resultsServers">
          </li>
        </ul>
        <ul>

        </ul>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchKeywords: null,
                resultsServers: [],
                resultsSites: [],
                loading: false
            };
        },

        watch: {
            keywords(after, before) {
                this.loadResults();
            }
        },

        methods: {

            async loadResults() {
                this.loading = true

                try {
                    this.resultsSites = await this.$api.serverSites.list(this.searchKeywords);
                    console.log(this.resultsSites);
                    this.resultsServers = await this.$api.servers.list(this.searchKeywords);
                    console.log(this.resultsServers);
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
        }

    }
</script>
