<template>
    <div class="stats stats-vertical shadow">
        <div class="stat" v-if="serverData">
            <div class="stat-title">Name: {{ serverData.name.slice(0, 14) }}...</div>
            <div class="stat-title">Players: {{ serverData.players }}/{{ serverData.maxPlayers }}</div>
            <div class="stat-title">Map: {{ serverData.details.map.slice(0, 14) }}...</div>
            <div class="stat-title">Last wipe: {{ formattedDate ? formattedDate : 'Loading...' }}...</div>
            <div class="stat-title">World size: {{ serverData.details.rust_world_size }}</div>
            <div class="stat-title">World seed: {{ serverData.details.rust_world_seed }}</div>
        </div>
        <button class="btn" @click="connectToServer">Connect</button>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
    name: 'Monitoring',
    props: {
        serverId: {
            type: Number,
            required: true
        }
    },
    setup(props) {
        const serverData = ref(null);
        const formattedDate = ref(null);

        const fetchPlayerCount = async () => {
            try {
                const response = await fetch(`https://api.battlemetrics.com/servers/${props.serverId}`);
                const data = await response.json();
                serverData.value = data.data.attributes;
            } catch (error) {
                console.error(error);
            }
        };

        const connectToServer = () => {
            window.location.href = 'steam://connect/[IP]:[PORT]';
        };

        onMounted(() => {
            fetchPlayerCount();

            const intervalId = setInterval(fetchPlayerCount, 5000);
            onUnmounted(() => clearInterval(intervalId));
        });

        if (serverData.value) {
            const date = new Date(serverData.value.details.rust_last_wipe);
            const day = date.getDate();
            const month = date.toLocaleString('default', { month: 'long' });
            formattedDate.value = `${day} ${month}`;
            console.log(serverData.value);
        }

        return {
            serverData,
            formattedDate,
            connectToServer
        };
    }
};
</script>
