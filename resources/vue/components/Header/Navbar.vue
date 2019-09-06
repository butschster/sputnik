<template>
    <nav class="navbar">
        <div class="flex-1 pl-6 relative">
            <FormInput v-model="keywords" label="Search..." @input="fetch" name="name" class="form-group-search"/>
            <div v-if="show" class="absolute inset-x-0 results-list ml-6">
                <ResultsList :results="resultsServer" title-list-results="Servers" v-if="resultsServer"/>
                <ResultsList :results="resultsSites" title-list-results="Sites" v-if="resultsSites"/>
                <p v-if="!resultsServer && !resultsSites">{{ error }}</p>
            </div>
        </div>
        <router-link :to="$link.notifications()" class="notifications-link">
            <i class="far fa-bell fa-lg"></i>
        </router-link>

        <div class="navbar__divider"></div>

        <ProfileNav/>
    </nav>
</template>
<script>
    import ProfileNav from "@vue/components/Header/partials/ProfileNav"
    import FormInput from '@vue/components/Form/Input'
    import ResultsList from '@vue/components/Search/List'

    export default {
        components: {ProfileNav, FormInput, ResultsList},
        data() {
            return {
                keywords: '',
                show: false,
                resultsServer: null,
                resultsSites: null,
                error: ''
            }
        },

        created() {
            document.addEventListener('click', () => { this.show = false });
        },
        methods: {
            async fetch() {
                this.loading = true;
                this.show = true;

                try {
                    this.resultsServer = await this.$api.server.search(this.keywords);
                    console.log(this.resultsServer);
                    console.log(this.keywords);

                    this.resultsSites = await this.$api.serverSites.search(this.keywords);
                    console.log(this.$api.serverSites.search(this.keywords));
                    console.log(this.keywords)

                } catch (e) {
                    this.error = 'No results found containing' + '  " ' + this.keywords + ' "  ' ;
                }

                this.loading = false
            }
        }
    }
</script>
