<template>
    <div class="sidebar-section">
        <h5>Account</h5>
        <div class="nav">
            <router-link class="nav-link" :to="$link.profile()">
                Profile
            </router-link>
            <router-link class="nav-link" :to="$link.profileTeams()">
                Teams
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {}
</script>