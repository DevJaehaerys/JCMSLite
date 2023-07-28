<template>
    <input type="checkbox" id="payment-methods" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box relative">
            <label for="payment-methods" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <h3 class="text-lg font-bold text-center mb-5">Available payment methods</h3>
            <div class="justify-center flex">
                <button v-for="method in methods" :key="method.name" class="btn mr-1 btn-xs sm:btn-sm md:btn-md lg:btn-lg" @click="handleClick(method.name)">
                    <Icon :icon="method.icon" class="mr-2 text-3xl" />{{ method.name }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Icon } from '@iconify/vue';
import { methods } from '@/data/methods';
import {router} from "@inertiajs/vue3";
export default {
    name: 'PaymentMethods',
    components: {
        Icon,
    },
    props: {
        amount: {
            type: String,
            default: '',
        },
    },
    setup(props) {

        const handleClick = async (paymentMethod) => {
            try {
                const response = await router.post(`/payment/${paymentMethod}/redirect`, { Balance: props.amount });
            } catch (error) {
                console.log(error);
            }
        };

        return {
            methods,
            handleClick,
        };
    },
};
</script>
