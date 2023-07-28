<template>
    <div class="modal">
        <div class="modal-box relative">
            <label for="update-modal" class="btn btn-sm btn-circle absolute right-2 top-2" @click="closeModal"
            >✕</label
            >
            <h3 class="text-4xl mb-5 font-bold text-center">EDIT</h3>
            <form class="flex justify-center flex-col items-center" @submit.prevent="handleSubmit">
                <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
                <input
                    type="text"
                    placeholder="Type name here"
                    :class="`input input-bordered input-info w-full max-w-xs ${errors.name ? 'border-red-500' : ''}`"
                    id="name"
                    v-model="values.name"
                    @input="handleChange('name', $event.target.value)"
                />
                <div v-if="errors.about" class="text-red-500 text-sm mt-1">{{ errors.about }}</div>
                <input
                    type="text"
                    placeholder="Type about here"
                    :class="`input input-bordered input-info w-full max-w-xs ${errors.about ? 'border-red-500' : ''}`"
                    id="about"
                    v-model="values.about"
                    @input="handleChange('about', $event.target.value)"
                />
                <div v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price }}</div>
                <input
                    type="text"
                    placeholder="Type price here"
                    :class="`input input-bordered input-info w-full max-w-xs ${errors.price ? 'border-red-500' : ''}`"
                    id="price"
                    v-model="values.price"
                    @input="handleChange('price', $event.target.value)"
                />
                <div v-if="errors.command" class="text-red-500 text-sm mt-1">{{ errors.command }}</div>
                <input
                    type="text"
                    placeholder="Type command here"
                    :class="`input input-bordered input-info w-full max-w-xs ${errors.command ? 'border-red-500' : ''}`"
                    id="command"
                    v-model="values.command"
                    @input="handleChange('command', $event.target.value)"
                />
                <button class="btn w-52 mt-5">Save</button>
                <button type="button" class="btn w-52 mt-5" @click="handleDelete">Delete</button>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue';
import {router} from "@inertiajs/vue3";

export default {
    props: {
        selectedId: {
            type: Number,
            required: true
        }
    },
    setup(props) {
        const state = reactive({
            values: {
                name: '',
                about: '',
                price: '',
                command: ''
            },
            errors: {}
        });
        const fetchProduct = async () => {
            try {
                const response = await axios.get(`/шк/${props.selectedId}`);
                state.values = response.data;
            } catch (error) {
                console.log(error);
            }
        };

        const handleSubmit = async () => {
            try {
                const response = await axios.put(`/products/${props.selectedId}`, state.values);
                router.replace(`/products/${props.selectedId}`);
            } catch (error) {
                state.errors = error.response.data.errors;
            }
        };

        const handleDelete = async () => {
            try {
                const response = await axios.delete(`/products/${props.selectedId}`);
                router.replace(`/products`);
            } catch (error) {
                console.log(error);
            }
        };

        const closeModal = () => {
            router.replace(`/products/${props.selectedId}`);
        };

        const handleChange = (key, value) => {
            state.values[key] = value;
        };

        fetchProduct();

        return {
            ...toRefs(state),
            handleSubmit,
            handleDelete,
            closeModal,
            handleChange
        };
    }
};
</script>
