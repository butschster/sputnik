<template>
    <div class="sidebar-section" v-if="server && isConfigured">
        <h5>{{ $t('server.sections.title') }}</h5>

        <nav class="nav">
            <router-link v-for="(item, index) in links" :key="index" class="nav-link" :to="item.link(server)">
                <span class="w-8 inline-block"><i class="fas" :class="item.icon"></i></span>
                {{ $t(item.title) }}
            </router-link>
        </nav>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters('server', {
                server: 'getServer',
                isConfigured: 'isConfigured',
                links: 'links'
            }),
        }
    }
</script>
