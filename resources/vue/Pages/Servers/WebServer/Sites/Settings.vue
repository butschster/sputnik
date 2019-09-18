<template>
    <div>
        <h2>Settings</h2>

        <div class="alert alert-warning" v-if="!site.has_env">
            Site doesn't have environment variables
            <router-link :to="$link.serverSiteEnvironment(site)">
                Configure
            </router-link>
        </div>

        <div class="section section--border-b mt-10">
            <table class="table">
                <col width="200px">
                <col>
                <tbody>
                <tr>
                    <th>Path</th>
                    <td>
                        <Copy :text="site.path"/>
                    </td>
                </tr>
                <tr>
                    <th>Public path</th>
                    <td>
                        <Copy :text="site.public_path"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <Repository :site="site" class="mb-10" />
        <PublicKey :site="site" class="section--border-b" />
        <WebHook :site="site" class="section--border-b" />
        <Destroy :site="site" />
    </div>
</template>

<script>
    import PublicKey from "@vue/components/Server/Sites/partials/Settings/PublicKey"
    import WebHook from "@vue/components/Server/Sites/partials/Settings/WebHook"
    import Repository from "@vue/components/Server/Sites/Form/Repository"
    import Destroy from "@vue/components/Server/Sites/partials/Destroy"

    export default {
        components: {Destroy, Repository, PublicKey, WebHook},
        computed: {
            site() {
                return this.$parent.site
            }
        }
    }
</script>
