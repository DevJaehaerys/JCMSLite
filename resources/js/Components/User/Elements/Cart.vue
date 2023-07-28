<template>
    <div class="dropdown dropdown-start">
        <label tabIndex={0} class="btn btn-ghost btn-circle avatar">
            <Icon class="text-3xl" icon="material-symbols:shopping-cart-outline"/>

        </label>
        <ul style="    left: -100px!important;
    top: 40px!important;" tabIndex={0} class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-72">
            <li v-if="cartItems.length >= 1" v-for="item in cartItems">
                <div class="flex items-center relative">
                    <div @click="deleteFromCart(item.id)" class="badge z-50 badge-error absolute top-0 right-0">
                        X
                    </div>
                    <div class="pr-10 relative">
                        <p class="absolute top p-1 text-secondary-content text-sm bg-secondary rounded-br-2xl">
                            x{{ item.quantity }}</p>
                        <img style="flex-shrink: 0;" width="150" height="150" alt="cart item" v-bind:src="item.image">
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xl font-bold">{{ item.name }}</p>
                        <p class="text-xl">{{ item.price * item.quantity }}$</p>
                    </div>
                </div>
            </li>
            <li v-else>
                <p class="p-4"> Cart is empty 😔
                </p>
            </li>
            <div v-if="cartItems.length >= 1" class="flex justify-around mt-5 mb-5">
                <p class="indicator-item badge badge-primary p-3"> Total price: {{ totalPrice }}$ </p>
                <label class="indicator-item badge p-3 badge-primary" @click="buyAsCart">Buy</label>
            </div>
        </ul>
    </div>
</template>

<script>
import {Icon} from '@iconify/vue';
import {notify} from "notiwind";
import axios from "axios";

export default {
    name: "Cart",
    props: {
        cartItems: {
            type: Array,
            required: true,
        },
        totalPrice: {
            type: Number,
            required: true,
        }
    },
    methods: {
        deleteFromCart(id) {
            axios.delete(`/removeFromCart/${id}`)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        buyAsCart() {
            axios.get("/buyAsCart", {})
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
    },
    components: {
        Icon
    },
}
</script>

<style scoped>

</style>
