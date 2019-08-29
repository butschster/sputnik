<template>
    <div v-if="isConfigured">
        <CreateForm :server="$parent.server" @created="onCreate"/>
        <SitesList :server="$parent.server" />
    </div>
</template>

<script>
    import SitesList from "@vue/components/Server/Sites/List"
    import CreateForm from "@vue/components/Server/Sites/Form/Create"

    export default {
        components: {CreateForm, SitesList},
        methods: {
            onCreate(site) {

            }
        },
        computed: {
            isConfigured() {
                return this.$parent.server.status == 'configured'
            }
        },
    }
</script>
