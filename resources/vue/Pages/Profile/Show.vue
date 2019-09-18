<template>
    <div>
        <div class="w-full">
            <div class="container pl-10 pt-12">
                <h1 class="mb-4">
                    {{ $t('user.profile.title') }}
                </h1>
            </div>
        </div>
        <div class="w-full">
            <div class="container pl-10">
                <div class="card">
                    <div class="card-body flex items-center">
                        <img :src="user.avatar" alt="" class="h-32 rounded-full">
                        <div class="ml-10 flex-1">

                            <h2>{{ user.name }}</h2>
                            <div class="text-gray-700">
                                {{ $t('user.profile.member_since') }} <strong>{{ user.created_at | moment("DD/MM/YYYY")
                                }}</strong>
                            </div>
                        </div>
                        <EditProfile/>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="container pl-10">

                <SourceControls :user="user" class="mt-12 section--border-b"/>
                <Deactivate/>
            </div>
        </div>
    </div>
</template>

<script>
    import EditProfile from "@vue/components/User/Form/Edit"
    import {mapGetters} from 'vuex'
    import Deactivate from "@vue/components/User/Deactivate";
    import SourceControls from "@vue/components/User/SourceControls";

    export default {
        components: {EditProfile, SourceControls, Deactivate},
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
