<template>
    <input type="checkbox" id="shop-modal" class="modal-toggle"/>
    <div class="modal" v-if="selectedItem">
        <div style="width: 350px" class="modal-box">
            <h3 class="font-bold text-lg text-center">{{ selectedItem.name }}</h3>
            <p class="py-4 text-center">{{ selectedItem.about }}</p>
            <img :src="selectedItem.image" :alt="selectedItem.name" class="w-72 m-auto"/>
            <div class="flex items-center justify-center mb-4">
                <label for="item-count" class="mr-2">Count:</label>
                <input type="number" required value="1" id="item-count" ref="itemCount"
                       class="input input-bordered w-16" min="1"/>
            </div>
            <div class="modal-action flex justify-center">
                <label for="shop-modal" class="btn">
                    Close
                </label>
                <label class="btn" @click="handleBuyClick">
                    Buy
                </label>
                <label class="btn" @click="toCart">
                    To cart
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import {notify} from "notiwind";

export default {
    name: "ShopModal",
    props: {
        selectedItem: {
            type: Object,
            required: true,
        },
    },

    methods: {
        handleBuyClick() {
            axios.post("/buyItem", {itemid: this.selectedItem.id, count: this.$refs.itemCount.value}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (response.status === 200) {
                        notify({
                            group: "foo",
                            title: "Success",
                            text: "Item bought successfully"
                        }, 4000)
                    }
                }).catch(error => {
                if (error.response) {
                    if (error.response.status === 401) {
                        notify({
                            group: "error",
                            title: "Unauthorized",
                            text: "Unauthorized"
                        }, 4000)
                    } else if (error.response.status === 404) {
                        notify({
                            group: "error",
                            title: "Item not found",
                            text: "Item not found"
                        }, 4000)
                    } else if (error.response.status === 403) {
                        notify({
                            group: "error",
                            title: "Not enough balance",
                            text: `You lack ${error.response.data.missingSum}$!`
                        }, 4000)
                    }
                } else {
                    console.log(error);
                }
            });
        },
        toCart(){
            axios.post("/itemToCart", {itemid: this.selectedItem.id, count: this.$refs.itemCount.value}, {
            })
                .then(response => {
                    if (response.status === 200) {
                        notify({
                            group: "foo",
                            title: "Success",
                            text: "Item added to cart"
                        }, 4000)
                    }
                }).catch(error => {
                if (error.response) {
                    if (error.response.status === 401) {
                        notify({
                            group: "error",
                            title: "Unauthorized",
                            text: "Unauthorized"
                        }, 4000)
                    } else if (error.response.status === 404) {
                        notify({
                            group: "error",
                            title: "Item not found",
                            text: "Item not found"
                        }, 4000)
                    }
                } else {
                    console.log(error);
                }
            });
        }


    },
};
</script>
