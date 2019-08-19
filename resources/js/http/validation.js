import Vue from 'vue'
import { mapGetters } from 'vuex'

Vue.mixin({
    computed: {
        ...mapGetters({
            httpErrors: 'validation/getErrors'
        })
    },
})