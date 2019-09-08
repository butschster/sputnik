<template>
    <nav class="navbar">
        <div class="flex-1 pl-6 relative">
            <CreateForm/>
        </div>
        <router-link :to="$link.notifications()" class="notifications-link">
            <i class="far fa-bell fa-lg"></i>
        </router-link>

        <div class="navbar__divider"></div>

        <ProfileNav/>
    </nav>
</template>
<script>
    import ProfileNav from "@vue/components/Header/partials/ProfileNav"
    import CreateForm from '@vue/components/Search/CreateForm'


    export default {
        components: {CreateForm, ProfileNav},
        data() {
            return {

            }
        },
    }
</script>
