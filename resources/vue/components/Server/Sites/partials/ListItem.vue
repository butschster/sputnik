<template>
    <router-link :to="$link.serverSite(site)" class="servers-list-item-wrapper">
        <div class="servers-list-item__name ml-5 font-medium">
            {{ site.domain }}
        </div>

        <div class="mr-5">
            <BadgeTaskStatus :task="site.task"/>
        </div>

        <Dropdown :icon="false">
            <template v-slot:title>
                <div class="servers-list-item__actions">
                    <i class="fas fa-cog"></i>
                </div>
            </template>

            <button class="dropdown-button btn-block " @click="deploy">
                <i class="fas fa-parachute-box mr-3"></i> Deploy now
            </button>

            <div class="dropdown-divider"></div>
            <router-link :to="$link.serverSiteSettings(site)" class="dropdown-link text-red-500">Destroy</router-link>
        </Dropdown>
    </router-link>
</template>

<script>
    import Dropdown from "@vue/components/UI/Dropdown"

    export default {
        components: {Dropdown},
        props: {
            site: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async deploy() {
                this.loading = true

                try {
                    await this.$api.serverSiteDeployment.deploy(this.site.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>
