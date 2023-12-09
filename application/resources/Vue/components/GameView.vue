<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";
import { ApiModule } from "../../ts/api/ApiModule";
import { useRoute } from "vue-router";
import { Location } from "../../ts/types";

const route = useRoute();
const api = new ApiModule();

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

const showGoogleMap = ref(false);
const showDestinationModal = ref(false);
const destinationLocation = ref(<Location>{});

onBeforeMount(async () => {
  const gameId = route.params.gameId as string;
  const { value: game, error } = await api.findGame(gameId);
  if (game) {
    const { value: location, error: locationError } = await api.findLocation(game.destination_location_id);
    if (location) {
      destinationLocation.value = location;
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
    <DestinationModal v-if="showDestinationModal" @hide-destination-modal="hideDestinationModal"
      :location="destinationLocation" />
  </div>
</template>