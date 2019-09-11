<template>
    <div v-if="hasResults">
        <strong class="search__results-list__title mb-2">{{ title }}</strong>
        <ul v-if="hasResults">
            <li v-for="result in results" class="search__results-list__item">
                <router-link :to="link(result)" class="search__results-list__link">
                    {{ result.name }}
                </router-link>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: {
            results: Array,
            title: String,
            type: String,
        },
        methods: {
            link(result) {
                if (this.type == 'server') {
                    return this.$link.server(result)
                }
                return this.$link.serverSite(result)
            }
        },
        computed: {
            hasResults() {
                return this.results.length > 0
            }
        }
    }
</script>
