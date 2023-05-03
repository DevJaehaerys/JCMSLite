<template>
    <div>
        {{ error ? error : (playerCount === null ? 'Loading...' : `Players Online: ${playerCount}`) }}
    </div>
</template>

<script>
import { reactive, onMounted, onUnmounted } from 'vue';

export default {
    setup() {
        const state = reactive({
            playerCount: null,
            error: null,
        });

        const fetchPlayerCount = async () => {
            try {
                const response = await fetch('/api/online');
                if (!response.ok) {
                    throw new Error('Back-end error');
                }
                const data = await response.json();
                state.playerCount = data.Players;
                state.error = null;
            } catch (error) {
                console.error(error);
                state.playerCount = null;
                state.error = 'Server not available';
            }
        };

        onMounted(() => {
            fetchPlayerCount();
            state.intervalId = setInterval(fetchPlayerCount, 30000);
        });

        onUnmounted(() => {
            clearInterval(state.intervalId);
        });

        return state;
    },
};
</script>
