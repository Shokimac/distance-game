<script setup lang="ts">
import { toRefs } from "vue";
import { Location, Player } from "../../../ts/types";

interface Props {
	destinationLocation: Location;
	players: Player[];
	playerLocations: Location[];
	playerDistances: number[];
	showPlayerInfo: boolean;
	showPlayerTurnMordal: boolean;
}
const props = defineProps<Props>();
const { destinationLocation, players } = props;
const { playerLocations, showPlayerInfo, showPlayerTurnMordal } = toRefs(props);

interface Emits {
	(event: "toggleShowInfo"): void;
}
const emits = defineEmits<Emits>();
function toggleShowInfo() {
	emits("toggleShowInfo");
}
</script>

<template>
  <div class="w-full z-10 absolute bottom-32 bg-white pb-20" v-if="showPlayerTurnMordal">
    <div class="w-full" @click="toggleShowInfo">
      <div class="w-8 h-1 bg-gray-400 mx-auto mt-3"></div>
    </div>
    <ul class="ml-5" v-show="showPlayerInfo">
      <li class="text-center">
        <p class="text-lg">目的地</p>
        <p class="text-xl font-bold">{{ destinationLocation.prefecture + destinationLocation.city +
          destinationLocation.town }}</p>
      </li>
      <li v-for="(player, index) in  players" :key="index" class="w-full px-1 py-4">
        <div class="flex w-full">
          <div class="flex align-items mx-1 w-12">
            <img :src="`/assets/icons/turn_${index + 1}.svg`" :alt="`${index + 1}番アイコン`" class="inline">
          </div>
          <div class="w-full flex flex-wrap ml-1">
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
            <div class="w-full truncate" v-if="playerLocations[index] !== undefined">
              住所: <span class="font-bold">{{ playerLocations[index].prefecture + playerLocations[index].city +
                playerLocations[index].town }}</span>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>