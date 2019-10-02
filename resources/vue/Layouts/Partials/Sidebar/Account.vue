<template>
    <div class="sidebar-section">
        <h5>{{ $t('user.sidebar.title') }}</h5>
        <nav class="nav">
            <router-link v-for="(item, index) in links" :key="index" class="nav-link" :to="item.link">
                <span class="w-8 inline-block"><i class="fas" :class="item.icon"></i></span>
                {{ $t(item.title) }}
            </router-link>
        </nav>
    </div>
</template>

<script>
    import LinksManager from '@js/LinksManager'

    export default {
        computed: {
            links() {
                return LinksManager.sidebar.links
            }
        }
    }
</script>
