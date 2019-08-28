<template>
    <div class="servers-list-item-wrapper">
        <div class="servers-list-item__status">
            <i class="icon fas fa-server"></i>
            <div class="status-indicator" :class="server.status"></div>
        </div>
        <div class="servers-list-item__name">
            <router-link :to="{name: 'server.show', params: {id: server.id }}">
                {{ server.name }}
            </router-link>
            <div class="servers-list-item__address">{{ server.ip }}</div>
        </div>
        <div class="servers-list-item__project">
            {{ server.team.name }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            server: Object
        }
    }
</script>