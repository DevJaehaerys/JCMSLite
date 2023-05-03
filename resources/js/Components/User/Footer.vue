<template>
    <footer className="footer footer-center p-4 bg-base-300 text-base-content">
        <div>
            <FooterOnline/>
            <p>Copyright © 2023 - JCMS Lite. </p>
        </div>
    </footer>
</template>

<script>
import FooterOnline from "@/Components/User/Elements/FooterOnline.vue";

export default {
    name: "Footer",
    components: {FooterOnline}
}
</script>

<style scoped>

</style>
