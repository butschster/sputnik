<template>
    <div class="results-list__list">
        <strong class="results-list__title mb-3">{{ titleListResults }}</strong>
        <ul>
            <li v-for="result in results" class="results-list__item">
                <router-link :to="$link.servers()" class="results-list__link">{{ result.name }}</router-link>
            </li>
        </ul>
    </div>

</template>
<script>
    export default {
        props: {
            results: Array,
            titleListResults: String,
        },
        data() {
            return {}
        },
    }
</script>
