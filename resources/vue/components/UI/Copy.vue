<template>
    <span class="btn-copy" v-if="text.length > 0"
          :class="{'btn-copy--copied': copied}"
          v-clipboard:copy="text"
          v-clipboard:success="onCopy"
          v-clipboard:error="onError"
    >
        <slot>{{ text }}</slot> <span class="btn-copy__label">{{ label }}</span>
    </span>
</template>

<script>
    export default {
        props: {
            text: String,
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
            label() {
                if (this.copied) {
                    return this.$t('app.buttons.copied')
                }

                return this.$t('app.buttons.copy')
            }
        }
    }
</script>
