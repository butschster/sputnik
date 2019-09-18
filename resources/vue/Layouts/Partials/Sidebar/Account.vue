<template>
    <div class="sidebar-section">
        <h5>Account</h5>
        <nav class="nav">
            <router-link class="nav-link" :to="$link.profile()">
                <span class="w-8 inline-block">
                        <i class="fas fa-key"></i></span>
                Profile
            </router-link>
            <router-link class="nav-link" :to="$link.profileTeams()">
                <span class="w-8 inline-block">
                    <i class="fas fa-chalkboard"></i></span>
                Teams
            </router-link>
        </nav>
    </div>
</template>

<script>
    export default {}
</script>
