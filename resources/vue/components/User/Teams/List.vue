<template>
    <div class="card">
        <div class="list-group list-group-flush">
            <router-link :to="{name: 'profile.team.show', params: {id: team.id }}" :key="team.id"
                         class="list-group-item"
                         v-for="team in teams">
                {{ team.name }}
            </router-link>
        </div>
    </div>
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
