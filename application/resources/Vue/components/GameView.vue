<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { GoogleMap, Marker, Polyline } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";
import { ApiModule } from "../../ts/api/ApiModule";
import { useRoute } from "vue-router";
import { Location, Player } from "../../ts/types";
import SubmitButton from "./ViewParts/SubmitButton.vue";
import SlotModal from "./ViewParts/SlotModal.vue";

interface LatLng {
  lat: number,
  lng: number
}

const route = useRoute();
const api = new ApiModule();

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

const showGoogleMap = ref(false);
const showDestinationModal = ref(false);
const destinationLocation = ref(<Location>{});
const destinationLocationLatLng = ref(<LatLng>{})
const playerLocationLatLng = ref(<LatLng[]>{})
const players = ref(<Player[]>[]);
const playerLocations = ref(<Location[]>[])
const playerDistances = ref(<number[]>[])
const playerTurn = ref(0);
const showSlotModal = ref(false);

onBeforeMount(async () => {
  const gameId = route.params.gameId as string;
  const { value: game, error } = await api.findGame(gameId);
  if (game) {
    const { value: location, error: locationError } = await api.findLocation(game.destination_location_id);
    if (location) {
      destinationLocation.value = location;
      destinationLocationLatLng.value.lat = parseFloat(location.latitude);
      destinationLocationLatLng.value.lng = parseFloat(location.longitude);

      const { value: playersData, error: getPlayerError } = await api.findPlayersByGame(game.id);
      players.value = playersData;
    }
  }
  showGoogleMap.value = true;
  showDestinationModal.value = true;
  console.log(playerLocationLatLng.value);
});

const hideDestinationModal = (() => {
  showDestinationModal.value = false;
})

const onShowSlotModal = (() => {
  showSlotModal.value = true;
})

const prickPin = ((location: Location) => {
  showSlotModal.value = false;
  const pinLatLng: LatLng = { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) }
  playerLocationLatLng.value[playerTurn.value] = pinLatLng

  playerLocations.value[playerTurn.value] = location;
  playerDistances.value[playerTurn.value] = calcDistance();

  changeTurn();
})

const R = Math.PI / 180;
function calcDistance(): number {
  const latA = destinationLocationLatLng.value.lat * R
  const lngA = destinationLocationLatLng.value.lng * R
  const latB = playerLocationLatLng.value[playerTurn.value].lat * R
  const lngB = playerLocationLatLng.value[playerTurn.value].lng * R

  return 6371 * Math.acos(Math.cos(latA) * Math.cos(latB) * Math.cos(lngB - lngA) + Math.sin(latA) * Math.sin(latB));
}

function changeTurn(): void {
  playerTurn.value++;
}
</script>

<template>
  <div class="relative" v-if="showGoogleMap">
    <GoogleMap :api-key="API_KEY" :center="destinationLocationLatLng" :zoom="10" style="width: 100%; height: 100vh;"
      :disable-default-ui="true">
      <Marker :options="{ position: destinationLocationLatLng }" />
      <Marker v-if="playerLocationLatLng[playerTurn]" :options="{ position: playerLocationLatLng[playerTurn] }" />
      <Polyline v-if="playerLocationLatLng[playerTurn]"
        :options="{ path: [destinationLocationLatLng, playerLocationLatLng[playerTurn]] }" />
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
                <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">{{
                  playerLocations[index]?.postal_code.substring(0, 3) ?? '000' }}</span><span
                  class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">{{
                    playerLocations[index]?.postal_code.substring(3, 7) ?? '0000' }}</span>
              </div>
              <div class="w-1/2 flex flex-col">
                <div class="w-full text-right font-bold">
                  <span class="text-forest font-din text-3xl">{{ playerDistances[index]?.toFixed(2)
                    ?? 0
                  }}</span>km
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
      <p class="text-xl font-bold text-center mt-5">{{ playerTurn + 1 }}番目のプレイヤー</p>
      <p class="text-xl font-bold text-center mb-5">{{ players[playerTurn].name }} さんの番です</p>
      <SubmitButton label="スロットを回す" @click="onShowSlotModal" />
    </div>
    <DestinationModal v-if="showDestinationModal" @hide-destination-modal="hideDestinationModal"
      :location="destinationLocation" />
    <SlotModal v-show="showSlotModal" @prick-pin="prickPin" />
  </div>
</template>