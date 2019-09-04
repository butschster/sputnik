<template>
    <div>
        <div class="section">
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

        <div class="card mt-4">
            <div class="card-header" >
                Git repository details

                <div v-if="$gate.allow('deploy', 'server', site)">
                    <button class="btn btn-warning btn-sm"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                </div>
            </div>

            <div class="progress rounded-0" v-if="site.is_deploying">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" aria-valuenow="75"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: 45%">Deployment</div>
            </div>

            <div class="alert alert-warning" v-if="!site.has_env">
                Site doesn't have environment variables
                <router-link :to="$link.serverSiteEnvironment(site)">
                    Configure
                </router-link>
            </div>

            <div class="card-header mt-10">
                Use this public key for access deployment

                <button class="btn btn-sm btn-primary" @click="registerPublicKey" v-if="site.repository.is_source_provider">
                    Register
                </button>
            </div>
            <pre class="break-all whitespace-normal mb-10">
                <Copy :text="site.server.public_key" />
            </pre>
            <div class="card-header">
                Deployment Trigger URL

                <button class="btn btn-sm btn-primary" @click="registerWebHook" v-if="site.repository.is_source_provider">
                    Register
                </button>
            </div>
            <p>
                Using a custom Git service, or want a service like Travis CI to run your tests before your
                application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous
                integration service finishes testing your application, instruct the service to make a GET or POST
                request to the following URL. Making a request to this URL will trigger your Forge deployment
                script:
            </p>
            <pre class="break-all whitespace-normal mt-5">
                <Copy :text="site.links.hooks_url" />
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