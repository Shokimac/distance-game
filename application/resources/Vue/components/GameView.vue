<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";
import { ApiModule } from "../../ts/api/ApiModule";
import { useRoute } from "vue-router";
import { EarthCoordinate } from "../../ts/types";

const route = useRoute();
const api = new ApiModule();

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

onBeforeMount(async () => {
  const gameId = route.params.gameId as string;
  const { value, error } = await api.findGame(gameId);
  if (value) {

  }
})

const center = { lat: 35.692041, lng: 139.7292123 };

const showDestinationModal = ref(true);

const hideDestinationModal = (() => {
  showDestinationModal.value = false;
})
</script>

<template>
  <div class="relative">
    <GoogleMap :api-key="API_KEY" :center="center" :zoom="17" style="width: 100%; height: 100vh;"
      :disable-default-ui="true">
      <Marker :options="{ position: center }" />
    </GoogleMap>
    <DestinationModal v-show="showDestinationModal" @hide-destination-modal="hideDestinationModal" />
  </div>
</template>