<template>
    <input type="checkbox" id="payment-methods" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box relative">
            <label for="payment-methods" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <h3 class="text-lg font-bold text-center mb-5">Available payment methods</h3>
            <div class="justify-center flex">
                <button v-for="method in methods" :key="method.name"
                        class="btn mr-1 btn-xs sm:btn-sm md:btn-md lg:btn-lg" @click="handleClick(method)">
                    <Icon :icon="method.icon" class="mr-2 text-3xl"/>
                    {{ method.name }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {Icon} from '@iconify/vue';
import {methods} from '@/data/methods';
import {router} from "@inertiajs/vue3";
import {notify} from "notiwind";

export default {
    name: 'PaymentMethods',
    components: {
        Icon,
    },
    props: {
        amount: {
            type: Number,
            default: '',
        },
    },
    setup(props) {
        const handleClick = async (paymentMethod) => {
            try {
                if (Number(props.amount) >= Number(paymentMethod.min)) {
                    await router.post(`/payment/${paymentMethod.name}/redirect`, {Balance: props.amount});
                } else {
                    notify({
                        group: "error",
                        title: "Error",
                        text: `Sorry, but minimum sum for ${paymentMethod.name} method = ${paymentMethod.min}$`
                    }, 4000)
                }
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
