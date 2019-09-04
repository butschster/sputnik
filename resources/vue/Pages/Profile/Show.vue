<template>
    <div>
        <h1 class="mb-4">
            Profile
        </h1>

        <div class="card">
            <div class="card-body flex items-center">
                <img :src="user.avatar" alt="" class="h-32 rounded-full">
                <div class="ml-10 flex-1">

                    <h2>{{ user.name }}</h2>
                    <div class="text-gray-700">Member since <strong>{{ user.created_at | moment("DD/MM/YYYY") }}</strong></div>
                </div>

                <button class="btn btn-default">Edit profile</button>
            </div>
        </div>

        <SourceControls class="mt-12 section--border-b"/>
        <Deactivate />
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Deactivate from "@vue/components/User/Deactivate";
    import SourceControls from "@vue/components/User/SourceControls";

    export default {
        components: {SourceControls, Deactivate},

        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
