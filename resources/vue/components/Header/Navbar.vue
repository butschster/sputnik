<template>
    <nav class="navbar">
        <div class="flex-1">
            <SearchForm />
        </div>
        <router-link :to="$link.notifications()" class="notifications-link">
            <i class="far fa-bell fa-lg"></i>
        </router-link>

        <div class="navbar__divider"></div>

        <ProfileNav/>
    </nav>
</template>
<script>
    import ProfileNav from "./partials/ProfileNav"
    import SearchForm from './Search/Form'


    export default {
        components: {SearchForm, ProfileNav},
        data() {
            return {

            }
        },
    }
</script>
