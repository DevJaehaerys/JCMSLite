<template>
    <div class="modal">
        <div class="modal-box relative">
            <label for="promocode-modal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <div class="flex items-center justify-center flex-col">
                <h3 class="font-bold text-lg">Promocode</h3>
                <div class="form-control">
                    <label class="label self-center">
                        <span class="label-text">Enter promocode</span>
                    </label>
                    <label class="input-group">
                        <input v-model="promocode" type="text" class="input input-bordered"/>
                    </label>
                </div>
                <div class="modal-action">
                    <label @click="sendPromo" class="btn">Use</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {notify} from "notiwind";

export default {
    name: "Promocode",
    data() {
        return {
            promocode: '123'
        }
    },
    methods: {
        sendPromo() {
            axios.post("/promo/check", {promocode: this.promocode}, {})
                .then(response => {
                    if (response.status === 200) {
                        notify({
                            group: "foo",
                            title: "Success",
                            text: `Promocode successfully used`
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
                    } else if (error.response.status === 403) {
                        notify({
                            group: "error",
                            title: "Already used",
                            text: "Promocode already used"
                        }, 4000)
                    } else if (error.response.status === 404) {
                        notify({
                            group: "error",
                            title: "Not found",
                            text: `Promocode not found`
                        }, 4000)
                    }
                } else {
                    console.log(error);
                }
            });
        },

    }
}
</script>
