<template>
    <nav class="navbar">
        <div class="flex-1">

        </div>
        <router-link :to="{name: 'notifications'}" class="notifications-link">
            <i class="far fa-bell fa-lg"></i>
        </router-link>

        <div class="navbar__divider"></div>

        <ProfileNav />
    </nav>
</template>
<script>
    import ProfileNav from "@vue/components/Header/partials/ProfileNav"
    export default {
        components: {ProfileNav}
    }
</script>
