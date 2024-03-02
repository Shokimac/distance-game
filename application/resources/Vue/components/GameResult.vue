<script setup lang="ts">
import { ApiModule } from '../../ts/api/ApiModule';
import { ref, onBeforeMount } from 'vue';
import SubmitButton from './ViewParts/SubmitButton.vue';
import { useRoute } from 'vue-router';
import { Player, Location } from '../../ts/types';
import ResultPlayerInfo from './ViewParts/ResultPlayerInfo.vue';

const api = new ApiModule();
const route = useRoute();
const gameId = route.params.gameId as string;
const topPlayer = ref(<Player>{});
const players = ref(<Player[]>[]);
const drawLocations = ref(<Location[]>[]);

onBeforeMount(async () => {
  const { value, error } = await api.findPlayersByGame(gameId);
  const { value: drawLocationData, error: getLocationError } = await api.getDrawLocations(gameId);
  value.sort((a, b) =>
    a.distance_to_destination > b.distance_to_destination ? 1 : -1);
  topPlayer.value = value[0];
  value.shift();
  drawLocations.value = drawLocationData;
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
          <p class="text-center text-xl"><span class="text-forest font-bold">{{ topPlayer.name }}</span>さん</p>
          <p class="text-center text-lg font-bold">目的地までの距離 <span class="text-forest font-bold text-3xl font-din">{{
            topPlayer.distance_to_destination }}</span>
            km
          </p>
        </div>
        <ResultPlayerInfo v-for="(player, index) in players" :key="index" :player="player" :rank="index + 1"
          :draw-location="drawLocations[player.draw_location_id]" />
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