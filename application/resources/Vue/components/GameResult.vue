<script setup lang="ts">
import { ApiModule } from '../../ts/api/ApiModule';
import { ref, onBeforeMount } from 'vue';
import SubmitButton from './ViewParts/SubmitButton.vue';
import { useRoute } from 'vue-router';
import { Player } from '../../ts/types';
import ResultPlayerInfo from './ViewParts/ResultPlayerInfo.vue';

const api = new ApiModule();
const route = useRoute();
const gameId = route.params.gameId as string;
const topPlayer = ref(<Player>{});
const players = ref(<Player[]>[]);

onBeforeMount(async () => {
  const { value, error } = await api.findPlayersByGame(gameId);
  value.sort((a, b) =>
    a.distance_to_destination < b.distance_to_destination ? 1 : -1);
  topPlayer.value = value[0];
  value.shift();
  players.value = value;
})

</script>

<template>
  <div class="flex flex-col h-screen">
    <h1
      class="mt-6 text-forest flex align-center justify-center font-din text-3xl relative font-extrabold
        before:content-[''] before:h-0.5 before:w-12 before:bg-forest before:mr-4 before:absolute before:top-1/3 before:left-14
        after:content-[''] after:h-0.5 after:w-12 after:bg-forest after:ml-4 after:absolute after:top-1/3 after:right-14">
      結果発表</h1>

    <div class="mt-2 w-full bg-[url('/assets/images/congrats.svg')] bg-contain bg-no-repeat grow relative">
      <div class="w-4/5 absolute left-10 top-48 bg-white">
        <div class="w-full py-1 bg-white border-2 border-forest">
          <p class="text-center text-xl"><span class="text-forest font-bold">{{ players[0].name }}</span>さん</p>
          <p class="text-center text-lg font-bold">目的地までの距離 <span class="text-forest font-bold text-3xl font-din">{{
            players[0].distance_to_destination }}</span>
            km
          </p>
        </div>
        <ResultPlayerInfo v-for="(player, index) in players" :key="index" :player="player" :rank="index + 1" />
        <div class="flex w-full mt-2">
          <div class="w-2/12">
            <img :src="`/assets/icons/rank_flag_3.svg`" :alt="`3着ランクアイコン`" class="inline mr-4 max-w-full">
          </div>
          <div class="w-10/12 flex">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">650</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0038</span>
              <p class="truncate">兵庫県神戸市中央区西町</p>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-right font-bold">
                <span class="text-forest font-din text-3xl">299.48</span>km
              </div>
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">しがない主婦さん
              </div>
            </div>
          </div>
        </div>
        <div class="flex w-full mt-2">
          <div class="w-2/12">
            <img :src="`/assets/icons/rank_flag_4.svg`" :alt="`4着ランクアイコン`" class="inline mr-4 max-w-full">
          </div>
          <div class="w-10/12 flex">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">158</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0093</span>
              <p class="truncate">東京都世田谷区上野毛</p>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-right font-bold">
                <span class="text-forest font-din text-3xl">701.14</span>km
              </div>
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">なるさん
              </div>
            </div>
          </div>
        </div>
        <div class="mt-2 w-full mx-auto">
          <SubmitButton label="もう一度遊ぶ" />
        </div>
        <div class="w-3/4 mt-5 mx-auto">
          <SubmitButton label="TOPに戻る" />
        </div>
      </div>
    </div>
  </div>
</template>