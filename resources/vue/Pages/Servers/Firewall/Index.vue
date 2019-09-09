<template>
    <div>
        <h1>
            Firewall
        </h1>

        <CreateFormFirewall :server="$parent.server" @created="load" class="well well-lg mb-12"/>

        <div v-if="hasRules">
            <h4>Active users ({{ rules.length }})</h4>
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col>
                <col class="w-48">
                <col class="w-48">
                <col class="w-48">
                <col class="w-48">
                <col class="w-32">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Port</th>
                    <th>From</th>
                    <th class="text-right">Policy</th>
                    <th class="text-right">Status</th>
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
                        <button class="btn btn-danger btn-sm" @click="remove(rule)" v-if="rule.is_editable">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1272/1272856.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any firewall rules yet</h3>
        </div>
    </div>
</template>

<script>
    import BadgeTaskStatus from "@vue/components/UI/Badge/TaskStatus"
    import Copy from "@vue/components/UI/Copy"
    import CreateFormFirewall from "@vue/components/Server/Firewall/CreateForm"

    export default {
        components: {CreateFormFirewall, Copy, BadgeTaskStatus},
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
            async load() {
                this.loading = true

                try {
                    this.rules = await this.$api.serverSearch.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onRemoved(rule) {
                this.load()

                this.$notify.success('Rule successfully deleted')
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

                return 'badge-error'
            }
        },
        computed: {
            hasRules() {
                return this.rules.length > 0
            }
        }
    }
</script>
