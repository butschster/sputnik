<template>
    <div class="sidebar-section">
        <h5>Account</h5>
        <div class="nav">
            <router-link class="nav-link" :to="{name: 'profile'}">
                Profile
            </router-link>
            <router-link class="nav-link" :to="{name: 'profile.teams'}">
                Teams
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {}
</script>