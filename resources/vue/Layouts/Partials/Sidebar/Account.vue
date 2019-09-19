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
    export default {
        computed: {
            links() {
                return [
                    {
                        title: 'user.sidebar.profile',
                        link: this.$link.profile(),
                        icon: 'fa-key'
                    },
                    {
                        title: 'user.sidebar.teams',
                        link: this.$link.profileTeams(),
                        icon: 'fa-chalkboard'
                    }
                ]
            }
        }
    }
</script>
