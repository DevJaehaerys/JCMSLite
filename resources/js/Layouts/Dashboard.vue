<template>
    <div class="flex flex-col min-h-screen">
        <nav class="navbar bg-neutral text-neutral-content">
            <a class="btn btn-ghost normal-case text-xl">JCMS Lite Dashboard</a>
            <label for="create-item-modal" class="btn w-32">Create item</label>
            <a href="/" class="btn w-32">Back home</a>
        </nav>
        <input type="checkbox" id="create-item-modal" class="modal-toggle" />
        <ModalCreate/>
        <div class="flex-grow z-10">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import ModalCreate from "@/Components/Admin/Elements/ModalCreate.vue";
export default {
    name: "Dashboard",
    components:{ModalCreate},
}
</script>

<style scoped>

</style>
