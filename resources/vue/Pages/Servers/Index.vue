<template>
    <div>
        <List/>
        <CreateForm class="mt-10"/>
    </div>
</template>
<script>
    import CreateForm from '@vue/components/Server/Form/Create'
    import List from '@vue/components/Server/List'

    export default {
        components: {List, CreateForm},
        mounted() {
            this.$store.dispatch('servers/loadServers')
        }
    }
</script>
