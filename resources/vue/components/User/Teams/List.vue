<template>
    <section class="servers-list">
        <h4>{{ $t('user.team.list.active') }} ({{ teams.length }})</h4>
        <div class="servers-list-items">
            <router-link :to="$link.profileTeam(team)" v-for="team in teams" :key="team.id" class="servers-list-item-wrapper" >
                <div class="servers-list-item__name ml-5 font-medium">
                    {{ team.name }}
                </div>
            </router-link>
        </div>
    </section>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters('auth', {
                teams: 'getTeams',
            }),
        }
    }
</script>
