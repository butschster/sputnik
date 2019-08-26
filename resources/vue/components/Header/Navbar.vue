<template>
    <nav class="navbar">
        <div class="flex-1">

        </div>

        <div class="navbar__profile dropdown" ref="dropdown">
            <img :src="user.avatar" alt="" class="user-info--avatar" @click="toggleDropdown">

            <Tooltip :reference="$refs" class="dropdown-menu" :show="dropdownOpen">
                <div class="user-info px-6 py-2">
                    <img :src="user.avatar" alt="" class="user-info--avatar">
                    <div class="user-info--name">
                        <router-link :to="{name: 'user.profile'}">{{ user.name }}</router-link>
                        <div class="user-info--email">
                            {{ user.email }}
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="" class="dropdown-link">Teams</a>
                <a href="" class="dropdown-link">Account</a>
                <a href="" class="dropdown-link">Sign out</a>
            </Tooltip>
        </div>
    </nav>
</template>
<script>
    import Tooltip from '@vue/components/UI/Tooltip'
    import {mapGetters} from 'vuex'

    export default {
        components: {Tooltip},
        data() {
            return {
                dropdownOpen: false
            }
        },
        methods: {
            toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen
            }
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
