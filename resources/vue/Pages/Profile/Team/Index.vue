<template>
    <div>
        <h1>Teams</h1>

        <div class="well well-lg mb-10">
            <div class="text-center  mb-10">
                <img class="mx-auto" src="https://image.flaticon.com/icons/svg/1171/1171856.svg" width="150px">

            </div>

            <Teams class="mb-0"/>
        </div>
    </div>
</template>

<script>
    import Teams from "@vue/components/User/Teams/List";

    export default {
        components: {Teams}
    }
</script>