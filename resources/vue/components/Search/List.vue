<template>
    <div class="results-list__list">
        <strong class="results-list__title mb-3">{{ titleListResults }}</strong>
        <ul>
            <li v-for="result in results" class="results-list__item">
                <router-link :to="$link.server(result)" class="results-list__link" v-if="titleListResults === 'Servers'">{{ result.name }}</router-link>
                <router-link :to="$link.serverSite(result)" class="results-list__link" v-if="titleListResults === 'Sites'">{{ result.name }}</router-link>
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
