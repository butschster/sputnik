<template>
    <div>
        <h4>Environment variables</h4>

        <table class="table mb-16" v-if="site.has_env">
            <col width="200px">
            <col>
            <col width="100px">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(value, key) in site.env">
                <th>{{ key }}</th>
                <td>{{ value }}</td>
                <td class="text-right">
                    <button class="btn btn-danger btn-sm" @click="onRemove(key)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1568/1568465.svg" alt="" width="150px">
            <h3 class="mb-0">Looks like you don't have any env variables yet</h3>
        </div>

        <div class="section well well-lg">
            <Loader :loading="uploadLoading" />
            <div class="section-header">
                Load from .env string
            </div>
            <Textarea v-model="uploadForm.variables" label="String with variables" name="variables" />
           <button class="btn btn-primary" @click="onUploadFile">Upload</button>
        </div>
    </div>
</template>

<script>
    import Textarea from "@vue/components/Form/Textarea"
    export default {
        components: {Textarea},
        data() {
            return {
                loading: false,
                uploadLoading: false,
                uploadForm: {
                    variables: null
                }
            }
        },
        methods: {
            async onRemove(key) {
                this.loading = true

                try {
                    this.$parent.site = await this.$api.serverSiteEnvironment.remove(this.site.id, key)
                    this.uploadForm.variables = null
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async onUploadFile() {
                this.uploadLoading = true

                try {
                    this.$parent.site = await this.$api.serverSiteEnvironment.upload(this.site.id, this.uploadForm.variables)
                    this.uploadForm.variables = null
                } catch (e) {
                    this.$handleError(e)
                }

                this.uploadLoading = false
            }
        },
        computed: {
            site() {
                return this.$parent.site
            }
        }
    }
</script>