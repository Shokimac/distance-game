<script setup lang="ts">
import { Player } from '../../../ts/types';

interface Props {
  player: Player,
  rank: number
}

const props = defineProps<Props>();
const { player, rank } = props;
</script>

<template>
  <div class="flex w-full mt-2">
    <div class="w-2/12">
      <img :src="`/assets/icons/rank_flag_2.svg`" :alt="`${rank}着ランクアイコン`" class="inline mr-4 max-w-full">
    </div>
    <div class="w-10/12 flex">
      <div class="w-1/2 font-bold text-center">
        <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">858</span><span
          class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0903</span>
        <p class="truncate">長崎県佐世保市上本山町</p>
      </div>
      <div class="w-1/2 flex flex-col">
        <div class="w-full text-right font-bold">
          <span class="text-forest font-din text-3xl">284.21</span>km
        </div>
        <div class="w-full text-sm truncate">
          <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">メガネザルさん
        </div>
      </div>
    </div>
  </div>
</template>