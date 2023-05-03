<template>
    <input type="checkbox" id="deposit-modal" class="modal-toggle" />

    <Deposit/>
    <div class="dropdown dropdown-end">
        <label tabIndex={0} class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
                <img v-bind:src="auth.avatar"  alt="user avatar"/>
            </div>
        </label>
        <ul tabIndex={0} class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
            <li>
                <label for="deposit-modal" class="justify-between">
                    Deposit
                    <span class="badge">{{auth.balance}}$</span>
                </label>
            </li>
            <li><a href="/logout">Logout</a></li>
        </ul>
    </div>
</template>

<script>
import {notify} from "notiwind";
import Deposit from "@/Components/User/Modals/Deposit.vue";
export default {
    name: "AuthDropdown",
    components: {Deposit},
    props: {
        auth: {
            type: Object,
            required: false,
        },
    },
}
</script>

<style scoped>

</style>
