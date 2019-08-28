<template>
    <section class="servers-list">
        <loader :loading="loading"/>
        <h4>Active Servers</h4>
        <div class="servers-list-items" v-if="hasServers">
            <ListItem v-for="server in servers" :server="server" :key="server.id"/>
        </div>
        <div v-else class="card">
            <div class="card-body text-center">
                <img class="mx-auto mb-5" src="https://www.freepngimg.com/download/cloud_computing/62412-blue-computing-icons-virtual-servers-computer-private.png" alt="" width="150px">
                <h3 class="mb-0">Looks like you don't have any servers</h3>
            </div>
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
        methods: {},
        computed: {
            ...mapGetters('servers', {
                servers: 'getServers',
                hasServers: 'hasServers',
                loading: 'isLoading'
            })
        }
    }
</script>
