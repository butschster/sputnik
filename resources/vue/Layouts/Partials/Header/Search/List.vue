<template>
    <div v-if="hasResults">
        <strong class="search__results-list__title mb-2">{{ title }}  ({{ results.length }})</strong>
        <div v-if="hasResults">
            <component :is="component"
                       :data="result"
                       v-if="component"
                       v-for="(result, i) in results"
                       :key="i"
                       class="search__results-list__item"
                       @onClick="click"
            />
        </div>
    </div>
</template>
<script>
    import SiteItem from "./SiteItem"
    import ServerItem from "./ServerItem"

    export default {
        components: {SiteItem, ServerItem},
        props: {
            results: Array,
            title: String,
            type: String,
        },
        methods: {
            click(link) {
                this.$router.push(link)
                this.$emit('onClick')
            }
        },
        computed: {
            hasResults() {
                return this.results.length > 0
            },
            component() {
                if (this.type == 'server') {
                    return 'ServerItem'
                }

                return 'SiteItem'
            }
        }
    }
</script>
