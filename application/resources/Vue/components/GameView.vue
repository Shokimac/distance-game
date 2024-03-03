<script setup lang="ts">
import { ref, onBeforeMount, watch } from "vue";
import { GoogleMap, Marker, Polyline } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";
import { ApiModule } from "../../ts/api/ApiModule";
import { useRoute, useRouter } from "vue-router";
import { Location, Player } from "../../ts/types";
import SubmitButton from "./ViewParts/SubmitButton.vue";
import SlotModal from "./ViewParts/SlotModal.vue";
import GamePlayerInfo from "./ViewParts/GamePlayerInfo.vue";

interface LatLng {
  lat: number,
  lng: number
}

const route = useRoute();
const router = useRouter();
const api = new ApiModule();

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

const mapZoom = 7;

const gameId = route.params.gameId as string;
const showGoogleMap = ref(false);
const showDestinationModal = ref(false);
const destinationLocation = ref(<Location>{});
const destinationLocationLatLng = ref(<LatLng>{})
const playerLocationLatLng = ref(<{ [key: number]: LatLng }>{});
const players = ref(<Player[]>[]);
const playerLocations = ref(<Location[]>[])
const playerDistances = ref(<number[]>[])
const playerTurn = ref(0);
const showSlotModal = ref(false);
const showPlayerTurnMordal = ref(false);
const showResultModal = ref(false);
const showPlayerInfo = ref(false);
const showGamePlayersModal = ref(true);

onBeforeMount(async () => {
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
});

const hideDestinationModal = (() => {
  showDestinationModal.value = false;
  showPlayerTurnMordal.value = true;
})

const onShowSlotModal = (() => {
  showSlotModal.value = true;
  showGamePlayersModal.value = false;
  showPlayerTurnMordal.value = false;
})

const prickPin = (async (location: Location) => {
  showSlotModal.value = false;
  const pinLatLng: LatLng = { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) }
  const calcDistanceRes = calcDistance(pinLatLng);

  const { value: saveDistance } = await api.saveDistanceToDestination(
    players.value[playerTurn.value].game_id,
    players.value[playerTurn.value].id,
    location.id,
    calcDistanceRes
  );

  if (saveDistance) {
    showGamePlayersModal.value = true;
    showPlayerInfo.value = false;
    playerLocationLatLng.value[playerTurn.value] = pinLatLng;
    playerLocations.value[playerTurn.value] = location;
    playerDistances.value[playerTurn.value] = calcDistanceRes;

    playerTurn.value++;
    if (!players.value[playerTurn.value]) {
      showGamePlayersModal.value = false;
      showResultModal.value = true;
    } else {
      showPlayerTurnMordal.value = true;
    }
  } else {
    console.error('算出した距離の保存処理に失敗しました');
  }
})

const R = Math.PI / 180;
function calcDistance(pinLatLng: LatLng): number {
  const latA = destinationLocationLatLng.value.lat * R
  const lngA = destinationLocationLatLng.value.lng * R
  const latB = pinLatLng.lat * R
  const lngB = pinLatLng.lng * R

  return 6371 * Math.acos(Math.cos(latA) * Math.cos(latB) * Math.cos(lngB - lngA) + Math.sin(latA) * Math.sin(latB));
}

function onClickResultLink(): void {
  router.push(`/result/${gameId}`)
}

function toggleShowInfo(): void {
  showPlayerInfo.value = !showPlayerInfo.value
}
</script>

<template>
  <div class="relative" v-if="showGoogleMap">
    <GoogleMap :api-key="API_KEY" :center="destinationLocationLatLng" :zoom="mapZoom" style="width: 100%; height: 100vh;"
      :disable-default-ui="true">
      <Marker :options="{ position: destinationLocationLatLng }" />
      <Marker v-if="playerLocationLatLng[playerTurn - 1]" :options="{ position: playerLocationLatLng[playerTurn - 1] }" />
      <Polyline v-if="playerLocationLatLng[playerTurn - 1]"
        :options="{ path: [destinationLocationLatLng, playerLocationLatLng[playerTurn - 1]] }" />
    </GoogleMap>
    <GamePlayerInfo v-show="showGamePlayersModal" :destination-location="destinationLocation" :players="players"
      :player-locations="playerLocations" :player-distances="playerDistances" :show-player-info="showPlayerInfo"
      :show-player-turn-mordal="showPlayerTurnMordal" @toggle-show-info="toggleShowInfo" />
    <div v-if="showPlayerTurnMordal && players[playerTurn]" class="w-full z-20 absolute bottom-0 bg-white pb-10">
      <p class="text-xl font-bold text-center mt-5">{{ playerTurn + 1 }}番目のプレイヤー</p>
      <p class="text-xl font-bold text-center mb-5"><span class="text-forest">{{ players[playerTurn].name }}</span> さんの番です
      </p>
      <SubmitButton label="スロットを回す" @click="onShowSlotModal" />
    </div>
    <div v-if="showResultModal" class="w-full absolute bottom-0 bg-white pb-10 pt-10">
      <SubmitButton label="結果発表はこちら" @click="onClickResultLink" />
    </div>
    <DestinationModal v-if="showDestinationModal" @hide-destination-modal="hideDestinationModal"
      :location="destinationLocation" />
    <SlotModal v-show="showSlotModal" :key="playerTurn" @prick-pin="prickPin" />
  </div>
</template>