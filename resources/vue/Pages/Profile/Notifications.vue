<template>
    <div class="w-full">
        <div class="container px-10 pt-12">
            <h1>Notifications</h1>

            <loader :loading="loading"/>

            <div class="servers-list-items" v-if="hasNotifications">

            </div>
            <div v-else class="well well-lg text-center">
                <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1908/1908693.svg" alt=""
                     width="100px">
                <h3 class="mb-0">Looks like you don't have any notifications</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default {
        methods: {
            async markAllAsRead() {
                await this.$store.dispatch(
                    'notifications/markNotificationsAsRead',
                    this.unreadNotifications.map(n => n.id)
                )
            }
        },
        computed: {
            ...mapState({
                loading: state => state.notifications.loading,
            }),
            ...mapGetters('notifications', {
                notifications: 'notifications',
                hasNotifications: 'hasNotifications',
                hasUnreadNotifications: 'hasUnreadNotifications',
                unreadNotifications: 'unreadNotifications'
            })
        }
    }
</script>
