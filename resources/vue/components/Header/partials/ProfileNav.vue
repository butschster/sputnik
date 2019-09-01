<template>
    <Dropdown class="navbar__profile" :arrow="false">
        <template v-slot:title>
            <img :src="user.avatar" class="user-info--avatar">
        </template>

        <div class="user-info px-6 py-2">
            <img :src="user.avatar" alt="" class="user-info--avatar">
            <div class="user-info--name">
                <router-link :to="{name: 'profile'}">{{ user.name }}</router-link>
                <div class="user-info--email">
                    {{ user.email }}
                </div>
            </div>
        </div>

        <div class="dropdown-divider"></div>
        <router-link :to="{name: 'profile'}" class="dropdown-link">Account</router-link>
        <router-link :to="{name: 'profile.teams'}" class="dropdown-link">Teams</router-link>
        <a href="#" @click="logout" class="dropdown-link">Sign out</a>

        <form ref="logout-form" action="/logout" method="POST" style="display: none;"></form>
    </Dropdown>
</template>

<script>
    import Dropdown from '@vue/components/UI/Dropdown'
    import {mapGetters} from 'vuex'

    export default {
        components: {Dropdown},
        methods: {
            logout() {
                this.$refs['logout-form'].submit();
            }
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>