<template>
    <div class="modal">
        <div class="modal-box relative">
            <label for="deposit-modal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <div class="flex items-center justify-center flex-col">
                <h3 class="font-bold text-lg">Deposit</h3>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Enter amount</span>
                    </label>
                    <label class="input-group">
                        <input type="text" placeholder="0.01" class="input input-bordered" v-model="amount" />
                        <span>USD</span>
                    </label>
                </div>
                <div class="modal-action">
                    <label for="payment-methods" class="btn">Buy</label>
                    <PaymentMethods :amount="amount" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PaymentMethods from "@/Components/User/Modals/PaymentMethods.vue";
export default {
    name: "Deposit",
    components: {PaymentMethods},
    data() {
        return {
            amount: ""
        }
    }
}
</script>
