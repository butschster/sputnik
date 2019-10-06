<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('supervisor.form.create.title') }}
            <p>{{ $t('supervisor.form.create.description') }}</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.command"
                       :label="$t('supervisor.form.create.command')"
                       name="command"
                       class="flex-1 mr-8" required/>

            <FormInput v-model="form.user"
                       :label="$t('supervisor.form.create.user')"
                       name="user"
                       class="mr-8"
                       required/>

            <FormInput v-model="form.processes"
                       :label="$t('supervisor.form.create.procs')"
                       name="processes"
                       class="mr-8" required/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">
                    {{ $t('supervisor.form.create.submit') }}
                </button>
            </div>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input.vue'

    export default {
        components: {FormInput},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    command: null,
                    processes: 1,
                    user: 'root'
                },
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const daemon = await this.$api.supervisor.store(this.server.id, this.form)
                    this.$emit('created', daemon)

                    this.$notify.success(this.$t('supervisor.message.created'))

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    command: null,
                    processes: 1,
                    user: 'root'
                }
            }
        }
    }
</script>
