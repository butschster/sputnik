<template>
    <div>
        <h1 class="flex items-center">
            <div class="flex-1">
                {{ $t('server.firewall.title') }}
            </div>
            <Switcher :value="$parent.server.firewall.status" @change="switchFirewallStatus"/>
        </h1>
        <CreateFormFirewall :server="$parent.server" @created="load" class="well well-lg mb-12"/>
        <div v-if="hasRules">
            <h4>{{ $t('server.firewall.active_rules')}} ({{ rules.length }})</h4>
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col class="w-1/6">
                <col class="w-1/6">
                <col class="w-1/6">
                <col class="w-1/6">
                <col class="w-1/6">
                <col class="w-1/6">
                <thead>
                <tr>
                    <th>{{ $t('server.firewall.table.name') }}</th>
                    <th>{{ $t('server.firewall.table.port') }}</th>
                    <th>{{ $t('server.firewall.table.from') }}</th>
                    <th class="text-right">{{ $t('server.firewall.table.policy') }}</th>
                    <th class="text-right">{{ $t('server.firewall.table.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="rule in rules">
                    <th>
                        {{ rule.name }}
                    </th>
                    <th>
                        {{rule.port}}
                    </th>
                    <td>
                        <span class="badge">{{ rule.from }}</span>
                    </td>
                    <td class="text-right">
                        <span class="badge" :class="policyBadgeClass(rule)">{{ rule.policy }}</span>
                    </td>
                    <td class="text-right">
                        <BadgeTaskStatus :task="rule.task"/>
                    </td>

                    <td class="text-right">
                        <button class="btn btn-danger btn-circle btn-sm" @click="remove(rule)"
                                v-if="rule.is_editable">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1272/1272856.svg" alt=""
                 width="100px">
            <h3 class="mb-0">{{ $t('server.firewall.message.empty_rules') }}</h3>
        </div>
    </div>
</template>

<script>
    import Switcher from 'vue-js-toggle-button/src/Button'
    import CreateFormFirewall from "@vue/components/Server/Firewall/CreateForm"

    export default {
        components: {CreateFormFirewall, Switcher},
        data() {
            return {
                loading: false,
                rules: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async switchFirewallStatus(state) {
                this.loading = true

                const method = state.value ? 'enable' : 'disable'
                try {
                    this.$parent.server.firewall.status = await this.$api.serverFirewall[method](this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },

            async load() {
                this.loading = true

                try {
                    this.rules = await this.$api.serverFirewall.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onRemoved(rule) {
                this.load()

                this.$notify.success(this.$t('server.firewall.message.deleted'))
            },
            async remove(rule) {
                this.loading = true

                try {
                    await this.$api.serverFirewall.remove(rule.id)
                    this.onRemoved(rule)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            policyBadgeClass(rule) {
                if (rule.policy == 'allow') {
                    return 'badge-success'
                }

                return 'badge-danger'
            }
        },
        computed: {
            hasRules() {
                return this.rules.length > 0
            }
        }
    }
</script>
