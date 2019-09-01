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

                <div class="mt-5">
                    <span class="badge" v-for="role in user.roles">{{ role.name }}</span>
                </div>
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
                    this.users = await this.$api.team.members(this.team.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>