<template>
    <span class="btn-copy" v-if="text.length > 0"
          :class="{'btn-copy--copied': copied}"
          v-clipboard:copy="text"
          v-clipboard:success="onCopy"
          v-clipboard:error="onError"
    >
        {{ text }} <span class="btn-copy__label">{{ label }}</span>
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
                console.error(e)
            }
        },
        computed: {
            label() {
                if (this.copied) {
                    return 'Copied'
                }

                return 'Copy'
            }
        }
    }
</script>