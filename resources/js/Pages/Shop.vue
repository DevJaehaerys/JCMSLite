<template>
    <Main :auth="auth">
        <div class="hero flex flex-col justify-center">
            <ShopCard :Items="Items"/>
        </div>
    </Main>
</template>

<script>
import ShopCard from "@/Components/User/Elements/ShopCard.vue";
import Main from "@/Layouts/Main.vue";

export default {
    name: "Shop",
    components: {ShopCard, Main},
    props: {
        Items: Object,
        auth: Object
    }
}
</script>

<style scoped>

</style>
