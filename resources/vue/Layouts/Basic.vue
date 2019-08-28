<template>
    <div class="min-w-full min-h-screen">
        <div class="flex min-h-screen">
            <aside class="sidebar">
                <div class="sidebar-section">
                    <h5>Manage</h5>
                    <div class="nav">
                        <router-link class="nav-link"  :to="{name: 'servers'}">
                            Servers
                        </router-link>
                    </div>
                </div>

                <ServerSidebar />
                <AccountSidebar />
            </aside>
            <div class="flex-1">
                <Navbar />
                <div class="container py-10 px-12 m-auto">
                    <router-view/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ServerSidebar from "@vue/components/Sidebar/Server";
    import AccountSidebar from "@vue/components/Sidebar/Account";
    import Navbar from '@vue/components/Header/Navbar'

    export default {
        components: {Navbar, AccountSidebar, ServerSidebar}
    }
</script>
