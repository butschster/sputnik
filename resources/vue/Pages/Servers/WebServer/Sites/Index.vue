<template>
    <div v-if="isConfigured">
        <h1>{{ $t('site.title') }}</h1>
        <div>
            <SitesList :server="$parent.server" />
            <CreateForm :server="$parent.server" @created="onCreate" class="mt-12"/>
        </div>
    </div>
</template>

<script>
    import SitesList from "@vue/components/Server/Sites/List"
    import CreateForm from "@vue/components/Server/Sites/Form/Create"
    import serverMixin from "@js/vue/mixins/server"

    export default {
        components: {CreateForm, SitesList},
        mixins: [serverMixin],
        methods: {
            onCreate(site) {

            }
        },
        computed: {
            server() {
                return this.$parent.server
            }
        },
    }
</script>
