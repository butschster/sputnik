<template>
    <span class="btn-copy" v-if="text.length > 0"
          :class="{'btn-copy--copied': copied}"
          v-clipboard:copy="text"
          v-clipboard:success="onCopy"
          v-clipboard:error="onError"
    >
        <slot>{{ label }}</slot>
        <span class="btn-copy__label">{{ copyLabel }}</span>
    </span>
</template>

<script>
    export default {
        props: {
            text: String,
            label: {
                default() {
                    return this.text
                }
            }
        },
        data() {
            return {
                copied: false,
            }
        },
        methods: {
            onCopy: function (e) {
                this.copied = true;

                setTimeout(() => {
                    this.copied = false;
                }, 1000);
            },
            onError: function (e) {
                this.$handleError(e)
            }
        },
        computed: {
            copyLabel() {
                if (this.copied) {
                    return this.$t('app.buttons.copied')
                }

                return this.$t('app.buttons.copy')
            }
        }
    }
</script>
