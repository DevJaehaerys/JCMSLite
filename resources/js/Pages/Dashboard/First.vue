<template>
    <Dashboard>
        <div class="hero">
            <div class="overflow-x-auto w-full">
                <Table :items="items" />
            </div>
        </div>
    </Dashboard>
</template>

<script>
import Dashboard from "@/Layouts/Dashboard.vue";
import Table from "@/Components/Admin/Table.vue";
export default {
    name: "First",
    props:{
        items: Object,
    },
    components:{Table, Dashboard}
}
</script>

<style scoped>

</style>
