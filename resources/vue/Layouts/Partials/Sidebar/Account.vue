<template>
    <div class="sidebar-section">
        <h5>Account</h5>
        <nav class="nav">
            <router-link class="nav-link" :to="$link.profile()">
                Profile
            </router-link>
            <router-link class="nav-link" :to="$link.profileTeams()">
                Teams
            </router-link>
        </nav>
    </div>
</template>

<script>
    export default {}
</script>