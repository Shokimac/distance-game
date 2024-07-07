<script setup lang="ts">
import { Player, Location } from "../../../ts/types";

interface Props {
	player: Player;
	rank: number;
	drawLocation: Location;
}

const props = defineProps<Props>();
const { player, rank, drawLocation } = props;
</script>

<template>
  <div class="flex w-full mt-2">
    <div class="w-2/12">
      <img :src="`/assets/icons/rank_flag_${rank}.svg`" :alt="`${rank}着ランクアイコン`" class="inline mr-4 max-w-full">
    </div>
    <div class="w-10/12 flex">
      <div class="w-1/2 font-bold text-center">
        <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">{{
          drawLocation.postal_code.substring(0, 3) ?? '000' }}</span><span class="font-extrabold text-xl">-</span><span
          class="text-forest text-3xl font-din">{{ drawLocation.postal_code.substring(3, 7) ?? '0000'
          }}</span>
        <p class="truncate">{{ drawLocation.prefecture + drawLocation.city + drawLocation.town }}</p>
      </div>
      <div class="w-1/2 flex flex-col">
        <div class="w-full text-right font-bold">
          <span class="text-forest font-din text-3xl">{{ player.distance_to_destination }}</span>km
        </div>
        <div class="w-full text-sm truncate">
          <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">{{ `${player.name}さん` }}
        </div>
      </div>
    </div>
  </div>
</template>