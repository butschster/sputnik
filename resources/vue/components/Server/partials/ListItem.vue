<template>
    <router-link :to="{name: 'server.show', params: {id: server.id }}" class="servers-list-item-wrapper">
        <ServerStatus class="mx-3" :server="server" />

        <div class="servers-list-item__name">
            <h4 class="mb-0">{{ server.name }}</h4>
            <div class="servers-list-item__address">{{ server.ip }}</div>
        </div>
        <div class="servers-list-item__project">
            {{ server.team.name }}
        </div>
    </router-link>
</template>

<script>
    import ServerStatus from "@vue/components/Server/partials/ServerStatus"
    export default {
        components: {ServerStatus},
        props: {
            server: Object
        }
    }
</script>
