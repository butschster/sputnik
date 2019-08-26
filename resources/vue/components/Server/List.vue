<template>
    <section class="servers-list">
        <loader :loading="loading"/>
        <h4>Servers</h4>
        <div class="servers-list-items">
            <ListItem v-for="server in servers" :server="server" :key="server.id"/>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import ListItem from './partials/ListItem'

    export default {
        components: {ListItem},
        mounted() {

        },
        methods: {

        },
        computed: {
            ...mapGetters('servers', {
                servers: 'getServers',
                loading: 'isLoading'
            })
        }
    }
</script>
