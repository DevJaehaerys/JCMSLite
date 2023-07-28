<template>
    <input type="checkbox" id="update-modal" class="modal-toggle" v-model="selectedItemId" />
    <div class="modal">
        <div class="modal-box relative">
            <label for="update-modal" class="btn btn-sm btn-circle absolute right-2 top-2">
                ✕
            </label>
            <h3 class="text-4xl mb-5 font-bold text-center">EDIT</h3>
            <div>
                <form class="flex justify-center flex-col items-center" @submit.prevent="handleSubmit">
                    <input
                        type="text"
                        placeholder="Type name here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.name ? 'border-red-500' : ''}`"
                        id="name"
                        v-model="values.name"
                        required
                    />
                    <input
                        type="text"
                        placeholder="Type about here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.about ? 'border-red-500' : ''}`"
                        id="about"
                        v-model="values.about"
                        required
                    />
                    <input
                        type="text"
                        placeholder="Type image here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.image ? 'border-red-500' : ''}`"
                        id="image"
                        v-model="values.image"
                        required
                    />
                    <input
                        type="text"
                        placeholder="Type command here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.command ? 'border-red-500' : ''}`"
                        id="command"
                        v-model="values.command"
                        required
                    />
                    <input
                        type="text"
                        placeholder="Type price here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.price ? 'border-red-500' : ''}`"
                        id="price"
                        v-model="values.price"
                        required
                    />
                    <input
                        type="text"
                        placeholder="Type category here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.category ? 'border-red-500' : ''}`"
                        id="category"
                        v-model="values.category"
                        required
                    />
                    <button class="btn w-52 mt-5" :disabled="Object.keys(errors).length > 0">Save</button>
                    <button type="button" class="btn w-52 mt-5" @click="handleDelete">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <table class="table w-full">
        <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Command</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in items" :key="item.id">
            <td>
                <div class="flex items-center space-x-3">
                    <div class="avatar">
                        <div class="mask mask-squircle w-12 h-12">
                            <img :src="item.image" alt="Item image" />
                        </div>
                    </div>
                    <div>
                        <div class="font-bold">{{ item.name }}</div>
                        <div class="text-sm opacity-50">{{ item.about.slice(0, 20) }}....</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge badge-ghost badge-sm">{{ item.price }}$</span>
            </td>
            <td>{{ item.command }}</td>
            <th>
                <label for="update-modal" class="btn btn-ghost btn-xs" @click="updateItem(item.id)">edit | remove</label>
            </th>
        </tr>
        </tbody>
    </table>
</template>
<script>
import { reactive, toRefs } from 'vue';
import {router} from "@inertiajs/vue3";
import axios from "axios";
export default {
    name: "Table",
    props: {
        items: Array,
    },
    setup(props) {
        const state = reactive({
            selectedItemId: null,
            values: {
                id: "",
                name: "",
                image: "",
                price: "",
                command: "",
                about: "",
                category: ""
            },
            errors: {},
        });

        const handleSubmit = () => {
            state.errors = {};


            if (Object.keys(state.errors).length === 0) {
                console.log(state.values);

                axios.put(`/items/${state.values.id}`, state.values)
                router.reload();
            }
        };

        const handleDelete = () => {
            axios.delete(`/items/${state.values.id}`);
            router.reload();
        };

        const updateItem = (itemId) => {
            state.selectedItemId = itemId;  // Находим элемент по id
            const selectedItem = props.items.find((item) => item.id === itemId);

            // Заполняем форму данными элемента
            state.values = { ...selectedItem };
        };

        return { ...toRefs(state), handleSubmit, handleDelete, updateItem };
    },
};
</script>
