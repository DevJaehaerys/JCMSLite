<template>
    <Main :auth="auth" name="Banlist">
        <div class="overflow-x-auto">
            <label for="search" class="sr-only">Search</label>
            <input
                type="text"
                id="search"
                name="search"
                placeholder="Search..."
                :value="searchQuery"
                @input="setSearchQuery($event.target.value)"
                class="input input-bordered border-none rounded-none w-full max-w-xs flex m-auto"
            />
            <table class="table table-zebra w-52 m-auto">
                <thead>
                <tr>
                    <th class="text-center">User</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Reason</th>
                    <th class="text-center">Unban time</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="player in filteredBanlist" :key="player.steamid">
                    <td>{{ player.name }}</td>
                    <td>{{ player.admin_name }}</td>
                    <td>{{ player.reason }}</td>
                    <td>
                        {{ player.expire === '0' ? 'Never' : new Date(player.expire * 1000).toLocaleString('en-US', {
                        hour12: false,
                        hourCycle: 'h23',
                        day: 'numeric',
                        month: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric'
                        })}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </Main>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import {computed, reactive, toRefs} from "vue";

export default {
    components: { Main },
    props: {
        auth: Object,
        banlist: Array,
    },
    setup(props) {
        const state = reactive({
            searchQuery: "",
        });

        const filteredBanlist = computed(() =>
            props.banlist.filter((player) =>
                player.name.toLowerCase().includes(state.searchQuery.toLowerCase())
            )
        );

        const setSearchQuery = (value) => {
            state.searchQuery = value;
        };

        return {
            ...toRefs(state),
            filteredBanlist,
            setSearchQuery,
        };
    },
};
</script>
