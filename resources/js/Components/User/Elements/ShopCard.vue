<template>
    <ShopModal :selectedItem="selectedItem" />

    <div class="flex">
        <input v-model="search" type="text" class="input w-full max-w-xs rounded-none flex m-auto" placeholder="Search by name" />
    </div>
    <div class="grid grid-flow-row gap-8 text-neutral-600 bg-base-300 p-8 shadow-2xl sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-10">
        <div v-for="item in filteredItems" :key="item.id" class="card w-72 bg-base-200 shadow-xl">
            <figure class="p-4">
                <img class="w-72" :src="item.image" :alt="item.name" />
            </figure>
            <div class="card-body">
                <h2 class="card-title text-base-content">{{ item.name }}</h2>
                <p class="text-base-content">{{ item.about }}</p>
                <label for="shop-modal" class="btn btn-primary w-auto" @click="selectItem(item)">Buy</label>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import ShopModal from "@/Components/User/Modals/Shop.vue";
import axios from "axios";

interface Item {
    id: number
    name: string
    about: string
    image: string
    category: string
}

export default defineComponent({
    name: "ShopCard",
    components: { ShopModal },
    props: {
        Items: {
            required: true,
        },
    },
    data() {
        return {
            selectedItem: null as Item | null,
            search: "",
        };
    },
    computed: {
        filteredItems(): Item[] {
            let items = this.Items;
            if (this.search) {
                items = items.filter((item) =>
                    item.name.toLowerCase().includes(this.search.toLowerCase())
                );
            }
            return items;
        },
    },
    methods: {
        selectItem(item: Item) {
            this.selectedItem = item;
            axios
                .post("/getItemInfo", { itemid: item.id })
                .then((response) => {
                    this.selectedItem = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
});
</script>
