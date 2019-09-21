<template>
    <div class="min-w-full min-h-screen pb-20">
        <div class="flex min-h-screen">
            <aside class="sidebar">
                <div class="sidebar-section">
                    <h5>{{ $t('app.sidebar.manage') }}</h5>
                    <div class="nav">
                        <router-link class="nav-link" :to="$link.servers()">
                            {{ $t('app.sidebar.servers') }}
                        </router-link>
                    </div>
                </div>

                <ServerSidebar/>
                <AccountSidebar/>
            </aside>
            <div class="relative bg-gray-100 flex-grow">
                <portal-target name="content-overlay"></portal-target>
                <Navbar />
                    <Breadcrumbs/>
                    <router-view/>
            </div>
        </div>
    </div>
</template>

<script>
    import ServerSidebar from "./Partials/Sidebar/Server"
    import AccountSidebar from "./Partials/Sidebar/Account"
    import Navbar from './Partials/Header/Navbar'
    import Breadcrumbs from './Partials/Breadcrumbs'

    export default {
        components: {
            Navbar,
            AccountSidebar,
            ServerSidebar,
            Breadcrumbs
        }
    }
</script>
