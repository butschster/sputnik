<template>
    <div>
        <h2>{{ $t('site.settings.title') }}</h2>

        <div class="alert alert-warning" v-if="!site.has_env">
            {{ $t('site.settings.environment.empty') }}
            <router-link :to="$link.serverSiteEnvironment(site)">
                {{ $t('site.settings.environment.button.configure') }}
            </router-link>
        </div>

        <div class="section section--border-b mt-10">
            <table class="table">
                <col width="200px">
                <col>
                <tbody>
                <tr>
                    <th>{{ $t('site.settings.table.domain') }}</th>
                    <td>
                        <Copy :text="site.domain"/>
                    </td>
                </tr>
                <tr>
                    <th>{{ $t('site.settings.table.web_server') }}</th>
                    <td>
                        {{ site.webserver.title }}
                    </td>
                </tr>
                <tr v-if="site.processor">
                    <th>{{ $t('site.settings.table.processor') }}</th>
                    <td>
                        {{ site.processor.title }}
                    </td>
                </tr>
                <tr>
                    <th>{{ $t('site.settings.table.path') }}</th>
                    <td>
                        <Copy :text="site.path"/>
                    </td>
                </tr>
                <tr>
                    <th>{{ $t('site.settings.table.public_path') }}</th>
                    <td>
                        <Copy :text="site.public_path"/>
                    </td>
                </tr>
                <tr v-if="site.is_proxy">
                    <th>{{ $t('site.settings.table.proxy_pass') }}</th>
                    <td>
                        <Copy :text="site.proxy_address"/>
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
