<template>
    <Drawer/>
    <ToastLib/>
    <div class="flex flex-col min-h-screen">
        <div class="background"/>
        <Navbar :auth="auth" />
        <div class="flex-grow mt-32 z-10">
            <slot></slot>
        </div>
        <Footer />
    </div>
</template>

<script>
import Navbar from "@/Components/User/Navbar.vue";
import Footer from "@/Components/User/Footer.vue";
import Drawer from "@/Components/User/Drawer.vue";
import ToastLib from "@/Components/User/Elements/ToastLib.vue";
export default {
    name: "Main",
    components: {ToastLib, Drawer, Navbar, Footer },
    props: {
        auth: {
            type: Object,
            required: false,
        },
    },
};
</script>

<style>
</style>
