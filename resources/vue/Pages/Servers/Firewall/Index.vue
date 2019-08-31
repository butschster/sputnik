<template>
    <div>
        <CreateFormFirewall :server="$parent.server" class="mb-12" @created="load(0)"/>

        <h4>Active users ({{ rules.data.length }})</h4>
        <div v-if="hasUsers">
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
                <tr v-for="rule in rules.data">
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
                        <BadgeStatus :status="rule.status"/>
                    </td>

                    <td class="text-right">
                        <button class="btn btn-danger btn-sm" @click="remove(rule)" v-if="rule.is_editable">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <Pagination :data="rules" @pagination-change-page="load"/>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1871/1871131.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any users yet</h3>
        </div>
    </div>
</template>

<script>
    import BadgeStatus from "@vue/components/UI/Badge/Status"
    import Copy from "@vue/components/UI/Copy"
    import Pagination from 'laravel-vue-pagination'
    import CreateFormFirewall from "@vue/components/Server/Firewall/CreateForm"

    export default {
        components: {CreateFormFirewall, Pagination, Copy, BadgeStatus},
        data() {
            return {
                loading: false,
                page: 1,
                rules: {
                    data: []
                }
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load(page = 1) {
                this.loading = true

                if (page > 0) {
                    this.page = page
                }

                try {
                    const response = await this.$api('v1.server.firewall.index', {server: this.$parent.server.id}).request({
                        page: this.page
                    })
                    this.rules = response.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            removedRule(rule) {
                this.load(0)
                this.$notify({
                    text: 'Rule successfully deleted',
                    type: 'success'
                });
            },
            async remove(rule) {
                this.loading = true

                try {
                    await this.$api('v1.server.firewall.delete', {rule: rule.id}).request()
                    this.removedRule(rule)
                } catch (e) {
                    console.error(e)
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
            hasUsers() {
                return this.rules.data.length > 0
            }
        }
    }
</script>
