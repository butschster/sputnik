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
            <div class="section-header">
                Information
            </div>

            <table class="table">
                <col width="200px">
                <col>
                <tbody>
                <tr>
                    <th>Path</th>
                    <td>{{site.path }}</td>
                </tr>
                <tr>
                    <th>Public path</th>
                    <td>{{ site.public_path }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="section section--border-b">
            <div class="section-header">
                Use this public key for access deployment

                <button class="btn btn-sm btn-primary" @click="registerPublicKey" v-if="site.repository.is_source_provider">
                    Register
                </button>
            </div>
            <pre class="break-all whitespace-normal">
                <Copy :text="site.server.public_key"/>
            </pre>
        </div>
        <div class="section">
            <div class="section-header">
                Deployment Trigger URL

                <button class="btn btn-sm btn-primary" @click="registerWebHook" v-if="site.repository.is_source_provider">
                    Register
                </button>

                <p>
                    Using a custom Git service, or want a service like Travis CI to run your tests before your
                    application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous
                    integration service finishes testing your application, instruct the service to make a GET or POST
                    request to the following URL. Making a request to this URL will trigger your Forge deployment
                    script:
                </p>
            </div>
            <pre class="break-all whitespace-normal mt-5">
                <Copy :text="site.links.hooks_url"/>
            </pre>
        </div>
    </div>
</template>

<script>
    import Copy from "@vue/components/UI/Copy"

    export default {
        components: {Copy},
        computed: {
            site() {
                return this.$parent.site
            }
        }
    }
</script>