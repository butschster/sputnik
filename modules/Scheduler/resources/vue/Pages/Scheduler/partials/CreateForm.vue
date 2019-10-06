<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('scheduler.form.create.title') }}
            <p>{{ $t('scheduler.form.create.description') }}</p>
        </div>
        <div class="flex flex-wrap">
            <FormInput v-model="form.name" :label="$t('scheduler.form.create.name')" name="name" class="mr-8" required
                       autofocus/>
            <FormInput v-model="form.command" :label="$t('scheduler.form.create.command')" name="command"
                       class="mr-8 flex-1" required/>
            <FormInput v-model="form.cron" :label="$t('scheduler.form.create.cron')" name="cron" class="mr-8" required/>
            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">
                    {{ $t('scheduler.form.create.submit') }}
                </button>
            </div>
        </div>

        <div>
            <span class="badge cursor-pointer mr-2" :class="{'badge-primary': form.cron == expr.expression}"
                  v-for="expr in expressions" @click="form.cron = expr.expression">
                {{ expr.name }}
            </span>
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
                    name: null,
                    command: null,
                    cron: '* * * * *',
                    user: 'root'
                },
                expressions: [
                    {
                        name: 'yearly',
                        expression: '0 0 1 1 *',
                    },
                    {
                        name: 'monthly',
                        expression: '0 0 1 * *',
                    },
                    {
                        name: 'weekly',
                        expression: '0 0 * * 0',
                    },
                    {
                        name: 'daily',
                        expression: '0 0 * * *',
                    },
                    {
                        name: 'hourly',
                        expression: '0 * * * *',
                    },
                    {
                        name: 'every minute',
                        expression: '* * * * *',
                    },
                ]
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const job = await this.$api.serverCron.store(this.server.id, this.form)
                    this.$emit('created', job)

                    this.$notify.success(this.$t('scheduler.message.created'))

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                    command: null,
                    cron: '* * * * *',
                    user: 'root'
                }
            }
        }
    }
</script>
