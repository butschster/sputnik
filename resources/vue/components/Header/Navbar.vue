<template>
    <nav class="navbar">
        <div class="flex-1 pl-6">
            <FormInput v-model="searchKeywords" @input="loadResults" label="Search..." name="name" class="flex-1 mr-8"/>
            <router-link class="nav-link" :to="{name: 'search'}">
                <i class="fas fa-search"></i>
            </router-link>
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
    import FormInput from '@vue/components/Form/Input'
    export default {
        components: {ProfileNav, FormInput},
        data() {
            return {

        }
        }

    }
</script>
