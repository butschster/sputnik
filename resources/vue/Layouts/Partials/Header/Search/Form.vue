<template>
    <div v-click-outside="hide" class="search-container">
        <FormInput v-model="query"
                   label="Search by resource name or IP"
                   name="search"
                   @focus="onFocus"
                   @blur="focused=false"/>

        <div v-if="show" class="search__results-list">
            <div v-if="hasResults">
                <Results :results="resultsServers" title="Servers" type="server" @onClick="reset" />
                <Results :results="resultsSites" title="Sites" type="site" class="mt-3" @onClick="reset"/>
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
    import {mapGetters} from 'vuex'
    import {debounce} from 'lodash'
    import FormInput from '@vue/components/Form/Input'
    import Results from './List'

    export default {
        components: {FormInput, Results},
        data() {
            return {
                focused: false,
                query: '',
                show: false,
                resultsServers: [],
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
            onFocus() {
                this.focused = true
                this.fetch()
            },
            async fetch() {
                this.loading = true
                this.show = true

                if (this.query.length > 0) {
                    this.findServers()
                    this.findSites()
                } else {
                    this.resultsServers = this.servers
                    this.resultsSites = await this.$api.sites.list()
                }

                this.loading = false
            },
            async findServers() {
                try {
                    this.resultsServers = await this.$api.server.search(this.query)
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
            reset() {
                this.hide()
                this.query = ''
                this.focused = false
            },
            hide(e) {
                this.show = false
            }
        },
        computed: {
            ...mapGetters('servers', {
                servers: 'getServers',
            }),
            hasResults() {
                return this.resultsServers.length > 0 || this.resultsSites.length > 0
            }
        }

    }
</script>
