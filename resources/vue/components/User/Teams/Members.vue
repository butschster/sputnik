<template>
    <div class="user-block">
        <h2>Members</h2>

        <div class="user-block__list">
            <Loader :loading="loading"/>
            <div class="user-block__item" v-for="user in users" :key="user.id">
                <div class="user-info">
                    <img :src="user.avatar" alt="" class="user-info--avatar">
                    <div class="user-info--name">
                        <h5>{{ user.name }}</h5>
                        <div class="user-info--email">
                            {{ user.email }}
                        </div>
                    </div>
                </div>

                @if($user->hasRole('owner', $team))
                <span class="user-block__item--role">owner</span>
                @endif
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            team: Object
        },
        data() {
            return {
                users: [],
                loading: false,
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.team.members', {team: this.team.id}).request()
                    this.users = response.data.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        }
    }
</script>