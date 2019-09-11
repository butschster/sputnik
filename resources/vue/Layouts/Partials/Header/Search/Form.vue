<template>
    <div v-click-outside="hide" class="search-container">
        <FormInput v-model="query"
                   label="Search by resource name or IP"
                   name="search"
                   @focus="focused=true"
                   @blur="focused=false"/>

        <div v-if="show" class="search__results-list">
            <div v-if="hasResults">
                <ResultsList :results="resultsServer" title="Servers" type="server"/>
                <ResultsList :results="resultsSites" title="Sites" type="site" class="mt-3"/>
            </div>
            <div v-else class="search__empty-results">
                No results found containing '{{ query }}'
            </div>
        </div>

        <portal to="content-overlay">
            <div class="search-overlay" :class="{active: focused}"></div>
        </portal>
    </div>
</template>
<script>
    import {debounce} from 'lodash'
    import FormInput from '@vue/components/Form/Input'
    import ResultsList from './List'

    export default {
        components: {FormInput, ResultsList},
        data() {
            return {
                focused: false,
                query: '',
                show: false,
                resultsServer: [],
                resultsSites: [],
                loading: false
            }
        },
        created: function () {
            this.debouncedFetch = debounce(this.fetch, 1000)
        },
        watch: {
            query(value) {
                this.debouncedFetch()
            }
        },
        methods: {
            fetch() {
                this.loading = true
                this.show = true

                if (this.query.length > 0) {
                    this.findServers()
                    this.findSites()
                }

                this.loading = false
            },
            async findServers() {
                try {
                    this.resultsServer = await this.$api.server.search(this.query)
                } catch (e) {
                    this.resultsServer = []
                }
            },
            async findSites() {
                try {
                    this.resultsSites = await this.$api.serverSites.search(this.query)
                } catch (e) {
                    this.resultsSites = []
                }
            },
            hide(e) {
                this.show = false
            }
        },
        computed: {
            hasResults() {
                return this.resultsServer.length > 0 || this.resultsSites.length > 0
            }
        }

    }
</script>
