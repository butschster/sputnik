<template>
    <div v-if="isConfigured" class="w-full">

        <div class="container pl-10">
            <h1>Sites</h1>
        </div>
            <SitesList :server="$parent.server"/>
            <CreateForm :server="$parent.server" @created="onCreate" class="mt-12"/>
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
