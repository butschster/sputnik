<template>
    <router-link :to="$link.server(server)" class="servers-list-item-wrapper">
        <ServerStatus class="mx-3" :server="server"/>

        <div class="servers-list-item__name">
            <h4 class="mb-0">{{ server.name }}</h4>
            <div class="servers-list-item__address">{{ server.ip }}</div>
        </div>

        <div class="servers-list-item__project mr-5">
            <span class="badge badge-primary">{{ server.team.name }}</span>
        </div>

        <div class="servers-list-item__date">
            <BadgeTimeFrom :date="server.created_at" />
        </div>

        <Dropdown :icon="false">
            <template v-slot:title>
                <div class="servers-list-item__actions">
                    <i class="fas fa-cog"></i>
                </div>
            </template>

            <template v-if="links.length > 0">
                <router-link v-for="(item, index) in links" :key="index" :to="item.link(server)" class="dropdown-link">
                    {{ $t(item.title) }}
                </router-link>
                <div class="dropdown-divider"></div>
            </template>

            <router-link :to="$link.serverSettings(server)" class="dropdown-link text-red-500">
                {{ $t('server.destroy.buttons.destroy') }}
            </router-link>
        </Dropdown>
    </router-link>
</template>

<script>
    import {Server as ServerModel} from "@js/models/Server"

    import Dropdown from "@vue/components/UI/Dropdown"
    import ServerStatus from "@vue/components/Server/partials/ServerStatus"

    export default {
        components: {ServerStatus, Dropdown},
        props: {
            server: Object
        },
        computed: {
            links() {
                return new ServerModel(this.server).links
            }
        }
    }
</script>
