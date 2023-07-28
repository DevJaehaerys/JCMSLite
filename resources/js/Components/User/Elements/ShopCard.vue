<template>
    <ShopModal :selectedItem="selectedItem"/>
    <input v-model="search" type="text" class="input xl:w-full md:max-w-xs  max-w-xs rounded-none flex m-auto"
           placeholder="Search by name"/>
    <div class="grid grid-flow-row gap-8 text-neutral-600 bg-base-200 p-8 shadow-2xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6">
        <button
            v-for="category in categories"
            :key="category"
            class="btn btn-primary mr-0 sm:mr-4"
            :class="{'bg-primary': category === selectedCategory}"
            @click="selectCategory(category)"
        >
            {{ category }}
        </button>
        <button class="btn btn-secondary" @click="resetCategory">All</button>
    </div>

    <div
        class="grid grid-flow-row gap-8 text-neutral-600 bg-base-300 p-8 shadow-2xl sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <div v-for="item in paginatedItems" :key="item.id" class="card w-72 bg-base-200 shadow-xl relative">
            <p class="absolute top p-2 text-secondary-content text-sm  bg-secondary rounded-br-2xl">${{ item.price }}</p>
            <figure class="p-4">
                <img class="w-72" :src="item.image" :alt="item.name"/>
            </figure>
            <div class="card-body">
                <h2 class="card-title text-base-content">{{ item.name }}</h2>
                <p class="text-base-content">{{ item.about }}</p>
                <label for="shop-modal" class="btn btn-primary w-auto" @click="selectItem(item)">Buy</label>
            </div>
        </div>
    </div>
    <div class="flex bg-base-300 justify-center items-center">
        <ul class="btn-group">
            <li :class="{ active: page === currentPage }" class="m-auto" v-for="page in displayedPages" :key="page">
                <template v-if="page === '...'">
                    <input type="number" v-model.number="customPage" class="btn bg-base-200" min="1" :max="totalPages" @keydown.enter="goToCustomPage">
                </template>
                <button v-else class="btn" @click="goToPage(page)">{{ page }}</button>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import ShopModal from "@/Components/User/Modals/Shop.vue";
import axios from "axios";

interface Item {
    id: number
    name: string
    about: string
    image: string
    price: number,
    category: string
}

export default defineComponent({
    name: "ShopCard",
    components: {ShopModal},
    props: {
        Items: {
            type: Array as () => Item[],
            required: true,
        },
    },
    data() {
        return {
            selectedItem: null as Item | null,
            search: "",
            selectedCategory: "",
            currentPage: 1,
            itemsPerPage: 8,
            customPage: null as number | null,
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
            if (this.selectedCategory) {
                items = items.filter(
                    (item) => item.category === this.selectedCategory
                );
            }
            return items;
        },
        paginatedItems(): Item[] {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.filteredItems.slice(startIndex, endIndex);
        },
        categories(): string[] {
            const categories = new Set<string>();
            this.Items.forEach((item) => {
                categories.add(item.category);
            });
            console.log(categories);
            return Array.from(categories);
        },
        totalPages(): number {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        },
        displayedPages(): Array<number | string> {
            const totalPages = this.totalPages;
            if (totalPages <= 7) {
                return Array.from({length: totalPages}, (_, i) => i + 1);
            } else {
                const currentPage = this.currentPage;
                if (currentPage <= 4) {
                    return [1, 2, 3, 4, 5, '...', totalPages];
                } else if (currentPage >= totalPages - 3) {
                    return [1, '...', totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages];
                } else {
                    return [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages];
                }
            }
        },
    },
    methods: {
        selectItem(item: Item) {
            this.selectedItem = item;
            axios
                .post("/getItemInfo", {itemid: item.id})
                .then((response) => {
                    this.selectedItem = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        selectCategory(category: string) {
            this.selectedCategory = category;
        },
        resetCategory() {
            this.selectedCategory = "";
        },
        goToPage(page: number | string) {
            if (page !== this.currentPage) {
                this.currentPage = Number(page);
                this.customPage = null;
            }
        },
        goToCustomPage() {
            if (this.customPage && this.customPage >= 1 && this.customPage <= this.totalPages) {
                this.currentPage = this.customPage;
            }
        },
    },
});
</script>
