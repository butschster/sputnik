<template>
    <router-link :to="{name: 'server.show', params: {id: server.id }}" class="servers-list-item-wrapper">
        <ServerStatus class="mx-3" :server="server"/>

        <div class="servers-list-item__name">
            <h4 class="mb-0">{{ server.name }}</h4>
            <div class="servers-list-item__address">{{ server.ip }}</div>
        </div>
        <div class="servers-list-item__project">
            <span class="badge">{{ server.team.name }}</span>
        </div>

        <Dropdown :icon="false">
            <template v-slot:title>
                <div class="servers-list-item__actions">
                    <i class="fas fa-cog"></i>
                </div>
            </template>

            <router-link :to="{name: 'profile'}" class="dropdown-link">Sites</router-link>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Add site</router-link>
            <div class="dropdown-divider"></div>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Users</router-link>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Firewall</router-link>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Database</router-link>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Scheduler</router-link>
            <router-link :to="{name: 'profile'}" class="dropdown-link">Supervisor</router-link>
            <div class="dropdown-divider"></div>
            <router-link :to="{name: 'profile'}" class="dropdown-link text-red-500">Destroy</router-link>
        </Dropdown>
    </router-link>
</template>

<script>
    import Dropdown from "@vue/components/UI/Dropdown"
    import ServerStatus from "@vue/components/Server/partials/ServerStatus"

    export default {
        components: {ServerStatus, Dropdown},
        props: {
            server: Object
        }
    }
</script>
