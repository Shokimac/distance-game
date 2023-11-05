<script setup lang="ts">
import { ref } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";
import DestinationModal from "./ViewParts/DestinationModal.vue";

const API_KEY = import.meta.env.VITE_GOOGLE_API_KEY;

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