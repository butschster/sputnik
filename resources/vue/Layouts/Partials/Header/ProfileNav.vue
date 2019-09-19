<template>
    <div>
        <Dropdown class="navbar__profile" :arrow="false">
            <template v-slot:title>
                <img :src="user.avatar" class="user-info--avatar">
            </template>

            <div class="user-info px-6 py-2">
                <img :src="user.avatar" alt="" class="user-info--avatar">
                <div class="user-info--name">
                    <router-link :to="$link.profile()">{{ user.name }}</router-link>
                    <div class="user-info--email">
                        {{ user.email }}
                    </div>
                </div>
            </div>

            <div class="dropdown-divider"></div>
            <router-link :to="$link.profile()" class="dropdown-link">
                {{ $t('user.header.dropdown.profile') }}
            </router-link>
            <router-link :to="$link.profileTeams()" class="dropdown-link">
                {{ $t('user.header.dropdown.teams') }}
            </router-link>
            <a href="#" @click="logout" class="dropdown-link">
                {{ $t('user.header.dropdown.logout') }}
            </a>

            <form ref="logout-form" action="/logout" method="POST" style="display: none;"></form>
        </Dropdown>
    </div>
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
