<template>
    <div>
        <FormInput v-model="keywords" label="Search..." @input="fetch" name="name" class="form-group-search"/>
        <div v-if="show" class="absolute inset-x-0 results-list ml-6" ref="searchResults">
            <ResultsList :results="resultsServer" title-list-results="Servers" v-if="resultsServer"/>
            <ResultsList :results="resultsSites" title-list-results="Sites" v-if="resultsSites"/>
            <p v-if="!resultsServer && !resultsSites">{{ error }}</p>
        </div>
    </div>
</template>
<script>
    import FormInput from '@vue/components/Form/Input'
    import ResultsList from '@vue/components/Search/List'

    export default {
        components: {FormInput, ResultsList},
        data() {
            return {
                keywords: '',
                show: false,
                resultsServer: null,
                resultsSites: null,
                error: ''
            }
        },

        mounted() {
            this.registerOutsideClose()
        },
        methods: {
            async fetch() {
                this.loading = true;
                this.show = true;

                try {
                    this.resultsServer = await this.$api.server.search(this.keywords);

                    this.resultsSites = await this.$api.serverSites.search(this.keywords);

                } catch (e) {
                    this.error = 'No results found containing' + '  " ' + this.keywords + ' "  ';
                }

                this.loading = false
            },
            registerOutsideClose() {
                const bodyClickHandler = (e) => {
                    if (!this.$refs.searchResults || e.target === this.$refs.searchResults || this.$refs.searchResults.contains(e.target)) {
                        return;
                    }

                    this.show = false
                }

                document.addEventListener('click', bodyClickHandler)
                this.$once('hook:destroyed', () => {
                    document.removeEventListener('click', bodyClickHandler)
                })
            }
        }

    }
</script>
