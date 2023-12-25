<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";
import { ApiModule } from "../../ts/api/ApiModule";
import { useRoute } from "vue-router";
import { Location, Player } from "../../ts/types";
import SubmitButton from "./ViewParts/SubmitButton.vue";

const route = useRoute();
const api = new ApiModule();

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

const showGoogleMap = ref(false);
const showDestinationModal = ref(false);
const destinationLocation = ref(<Location>{});
const players = ref(<Player[]>[]);

onBeforeMount(async () => {
  const gameId = route.params.gameId as string;
  const { value: game, error } = await api.findGame(gameId);
  if (game) {
    const { value: location, error: locationError } = await api.findLocation(game.destination_location_id);
    if (location) {
      destinationLocation.value = location;

      const { value: playersData, error: getPlayerError } = await api.findPlayersByGame(game.id);
      players.value = playersData;
    }
  }
  showGoogleMap.value = true;
  showDestinationModal.value = true;
});

const hideDestinationModal = (() => {
  showDestinationModal.value = false;
})
</script>

<template>
  <div class="relative" v-if="showGoogleMap">
    <GoogleMap :api-key="API_KEY"
      :center="{ lat: parseInt(destinationLocation.latitude), lng: parseInt(destinationLocation.longitude) }" :zoom="11"
      style="width: 100%; height: 100vh;" :disable-default-ui="true">
      <Marker
        :options="{ position: { lat: parseInt(destinationLocation.latitude), lng: parseInt(destinationLocation.longitude) } }" />
    </GoogleMap>
    <div class="w-full z-10 absolute bottom-32 bg-white pb-20">
      <div class="w-8 h-0.5 bg-gray-400 mx-auto mt-3"></div>
      <ul class="ml-5">
        <li v-for="(player, index) in players" :key="index" class="w-full px-2 py-4">
          <div class="flex w-full">
            <div class="w-12">
              <img :src="`/assets/icons/rank_flag_${index + 1}.svg`" :alt="`${index + 1}着ランクアイコン`"
                class="inline mr-4 max-w-full">
            </div>
            <div class="w-full flex">
              <div class="w-1/2 font-bold text-center">
                <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">000</span><span
                  class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0000</span>
              </div>
              <div class="w-1/2 flex flex-col">
                <div class="w-full text-right font-bold">
                  <span class="text-forest font-din text-3xl">0</span>km
                </div>
                <div class="w-full text-sm truncate">
                  <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">{{ player.name
                  }}さん
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="w-full z-20 absolute bottom-0 bg-white pb-10">
      <p class="text-xl font-bold text-center my-5">プレイヤー1の番です</p>
      <SubmitButton label="スロットを回す" />
    </div>
    <DestinationModal v-if="showDestinationModal" @hide-destination-modal="hideDestinationModal"
      :location="destinationLocation" />
  </div>
</template>