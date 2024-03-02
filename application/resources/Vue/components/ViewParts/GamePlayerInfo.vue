<script setup lang="ts">
import { toRefs } from 'vue'
import { Location, Player } from '../../../ts/types';

interface Props {
  destinationLocation: Location,
  players: Player[],
  playerLocations: Location[],
  playerDistances: number[],
  showPlayerInfo: boolean
}
const props = defineProps<Props>();
const { destinationLocation, players } = props
const { playerLocations, showPlayerInfo } = toRefs(props)

interface Emits {
  (event: "toggleShowInfo"): void;
}
const emits = defineEmits<Emits>();
function toggleShowInfo() {
  emits('toggleShowInfo');
}
</script>

<template>
  <div class="w-full z-10 absolute bottom-32 bg-white pb-20">
    <div class="w-8 h-0.5 bg-gray-400 mx-auto mt-3" @click="toggleShowInfo"></div>
    <ul class="ml-5" v-show="showPlayerInfo">
      <li>
        目的地: {{ destinationLocation.prefecture + destinationLocation.city + destinationLocation.town }}
      </li>
      <li v-for="(player, index) in  players" :key="index" class="w-full px-2 py-4">
        <div class="flex w-full">
          <div class="w-12">
            <img :src="`/assets/icons/rank_flag_${index + 1}.svg`" :alt="`${index + 1}着ランクアイコン`"
              class="inline mr-4 max-w-full">
          </div>
          <div class="w-full flex flex-wrap">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">{{
                playerLocations[index]?.postal_code.substring(0, 3) ?? '000' }}</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">{{
                  playerLocations[index]?.postal_code.substring(3, 7) ?? '0000' }}</span>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">{{ player.name
                }}さん
              </div>
            </div>
            <div class="w-full" v-if="playerLocations[index] !== undefined">
              {{ playerLocations[index].prefecture + playerLocations[index].city + playerLocations[index].town }}
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>