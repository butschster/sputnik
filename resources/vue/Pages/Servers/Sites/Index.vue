<template>
    <div v-if="isConfigured">
        <h1>Sites</h1>
        <div>
            <SitesList :server="$parent.server" />
            <CreateForm :server="$parent.server" @created="onCreate" class="mt-12"/>
        </div>
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
