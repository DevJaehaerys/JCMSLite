<template>
    <div class="modal">
        <div class="modal-box relative">
            <label for="create-item-modal" class="btn btn-sm btn-circle absolute right-2 top-2">×</label>
            <h3 class="text-4xl mb-5 font-bold text-center">Create item</h3>
            <div>
                <form class="flex justify-center flex-col items-center" @submit.prevent="handleSubmit">
                    <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{errors.name}}</div>
                    <input
                        type="text"
                        placeholder="Type name here"
                        :class="`input input-bordered input-info w-full max-w-xs ${errors.name && 'border-red-500'}`"
                        id="name"
                        v-model="values.name"
                        @input="handleChange"
                    />
                    <div v-if="errors.about" class="text-red-500 text-sm mt-1">{{errors.about}}</div>
                    <input
                        type="text"
                        placeholder="Type description here"
                        :class="`input mt-1 input-bordered input-info w-full max-w-xs ${errors.about && 'border-red-500'}`"
                        id="about"
                        v-model="values.about"
                        @input="handleChange"
                    />
                    <div v-if="errors.image" class="text-red-500 text-sm mt-1">{{errors.image}}</div>
                    <input
                        type="text"
                        placeholder="Type image here"
                        :class="`input mt-1 input-bordered input-info w-full max-w-xs ${errors.image && 'border-red-500'}`"
                        id="image"
                        v-model="values.image"
                        @input="handleChange"
                    />
                    <div v-if="errors.category" class="text-red-500 text-sm mt-1">{{errors.category}}</div>
                    <input
                        type="text"
                        placeholder="Type category here"
                        :class="`input mt-1 input-bordered input-info w-full max-w-xs ${errors.category && 'border-red-500'}`"
                        id="category"
                        v-model="values.category"
                        @input="handleChange"
                    />
                    <div v-if="errors.command" class="text-red-500 text-sm mt-1">{{errors.command}}</div>
                    <input
                        type="text"
                        placeholder="Type command here"
                        :class="`input mt-1 input-bordered input-info w-full max-w-xs ${errors.command && 'border-red-500'}`"
                        id="command"
                        v-model="values.command"
                        @input="handleChange"
                    />
                    <div v-if="errors.price" class="text-red-500 text-sm mt-1">{{errors.price}}</div>
                    <input
                        type="text"
                        placeholder="Type price here"
                        :class="`input mt-1 input-bordered input-info w-full max-w-xs ${errors.price && 'border-red-500'}`"
                        id="price"
                        v-model="values.price"
                        @input="handleChange"
                    />
                    <button class="btn w-52 mt-5">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import {router} from "@inertiajs/vue3";

export default {
    setup() {
        const values = ref({
            name: '',
            image: '',
            price: '',
            command: '',
            category: '',
            about: ''
        })

        const errors = ref({})

        function handleChange(e) {
            const key = e.target.id
            const value = e.target.value
            values.value = { ...values.value, [key]: value }
        }

        function handleSubmit() {
            if (validate()) {
                router.post('/items', values.value)
            }
        }

        function validate() {
            let errorsObj = {}
            let isValid = true

            if (!values.value.name.trim()) {
                errorsObj.name = 'Name is required'
                isValid = false
            }
            if (!values.value.about.trim()) {
                errorsObj.about = 'About is required'
                isValid = false
            }
            if (!values.value.image.trim()) {
                errorsObj.image = 'Image is required'
                isValid = false
            }
            if (!values.value.category.trim()) {
                errorsObj.category = 'Category is required'
                isValid = false
            }
            if (!values.value.price.trim()) {
                errorsObj.price = 'Price is required'
                isValid = false
            }
            if (!values.value.command.trim()) {
                errorsObj.command = 'Command is required'
                isValid = false
            }
            errors.value = errorsObj
            return isValid
        }

        return {
            values,
            errors,
            handleChange,
            handleSubmit
        }
    }
}
</script>

<style>

</style>
