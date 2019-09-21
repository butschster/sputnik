<template>
    <div class="w-full">
        <div class="container px-10 pt-12">
            <section class="servers-list">
                <loader :loading="loading"/>
                <h4 v-if="hasServers">{{ $t('server.list.title') }} ({{ servers.length }})</h4>

                <div class="servers-list-items" v-if="hasServers">
                    <ListItem v-for="server in servers" :server="server" :key="server.id"/>
                </div>

                <div v-else class="well well-lg text-center">
                    <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1421/1421309.svg" alt=""
                         width="100px">
                    <h3 class="mb-0">
                        {{ $t('server.list.message.empty') }}
                    </h3>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import ListItem from './partials/ListItem'

    export default {
        mounted() {
            this.$store.dispatch('servers/loadServers')
        },
        components: {ListItem},
        computed: {
            ...mapGetters('servers', {
                servers: 'getServers',
                hasServers: 'hasServers',
                loading: 'isLoading'
            })
        }
    }
</script>
