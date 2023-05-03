<template>
    <div class="overflow-x-auto">
        <table class="table table-zebra w-52 m-auto">
            <thead>
            <tr>
                <th @click="handleSort('UserID')">Avatar</th>
                <th @click="handleSort('Name')">Name</th>
                <th @click="handleSort('PVPKills')">PVP Kills</th>
                <th @click="handleSort('PVEKills')">PVE Kills</th>
                <th @click="handleSort('Deaths')">Deaths</th>
                <th @click="handleSort('KDR')">KDR</th>
                <th @click="handleSort('TimePlayed')">Time Played</th>
                <th @click="handleSort('ResourcesGathered')">ResourcesGathered</th>
                <th @click="handleSort('APCKills')">APCKills</th>
                <th @click="handleSort('HeliKills')">HeliKills</th>
                <th @click="handleSort('Economics')">Economics</th>
                <th @click="handleSort('HeadShots')">HeadShots</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="player in players" :key="player.UserID">
                <td class="flex gap-3 px-6 py-4 font-normal text-third">
                    <div class="relative h-10 w-10">
                        <a :href="`https://steamcommunity.com/profiles/${player.UserID}`" target="_blank" rel="noopener noreferrer" class="text-third text-start font-bold">
                            <img class="h-full w-full rounded-full object-cover object-center" :src="player.Avatar" alt="avatar">
                        </a>
                        <span v-if="player.Status === 'online'" class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                        <span v-else class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-400 ring ring-white"></span>
                    </div>
                </td>
                <td>{{ player.Name }}</td>
                <td>{{ player.PVPKills }}</td>
                <td>{{ player.PVEKills }}</td>
                <td>{{ player.Deaths }}</td>
                <td>{{ player.KDR }}</td>
                <td>{{ player.TimePlayed }}</td>
                <td>{{ player.ResourcesGathered }}</td>
                <td>{{ player.APCKills }}</td>
                <td>{{ player.HeliKills }}</td>
                <td>{{ player.Economics }}</td>
                <td>{{ player.HeadShots }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        players: {
            type: Array,
            required: true
        },
        handleSort: {
            type: Function,
            required: true
        }
    }
}
</script>

