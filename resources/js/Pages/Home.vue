<template>
<Main :auth="auth">
    <div class="hero">
        <div class="mockup-phone">
            <div class="camera"></div>
            <div class="display">
                <div class="artboard artboard-demo phone-1">
                    <img src="/img/Screenshot_1.png" alt="123"/>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-5">
        <div class="mockup-code">
            <pre data-prefix="$"><code>git clone https://github.com/DevJaehaerys/JCMSLite.git</code></pre>
            <pre data-prefix="$"><code>npm i</code></pre>
            <pre data-prefix="$"><code>composer install</code></pre>
            <pre data-prefix="$"><code>php artisan migrate</code></pre>
            <pre data-prefix="#"><code>// configure .env</code></pre>
            <pre data-prefix="$"><code>npm run build</code></pre>
            <div class="flex justify-center mt-5">
                <a href="https://github.com/DevJaehaerys/JCMSLite" class="btn btn-xs bg-base-100/100 sm:btn-sm md:btn-md lg:btn-lg">Github</a>
                <a href="https://docs.jaehaerys.dev/" class="btn btn-xs bg-base-100/100 sm:btn-sm md:btn-md lg:btn-lg">Documentation</a>
                <a href="https://discord.gg/J8pn9Kcm" class="btn btn-xs bg-base-100/100 sm:btn-sm md:btn-md lg:btn-lg">Buy paid version</a>
            </div>
        </div>
    </div>
</Main>
</template>

<script>
import Main from "@/Layouts/Main.vue";
export default {
    name: "Home",
    props:{
        auth: Object
    },
    components: {
        Main
    },
}
</script>

<style scoped>

</style>
