<script setup lang="ts">
import SubmitButton from './SubmitButton.vue';

interface Emits {
  (event: "hideDestinationModal"): void
}
const emit = defineEmits<Emits>();

const hideDestinationModal = (() => {
  emit("hideDestinationModal");
})
</script>

<template>
  <div class="w-full h-screen z-10 bg-shadow absolute top-0 left-0 flex justify-center items-center">
    <div class="w-11/12 bg-white rounded-lg z-20">
      <div class="w-full h-20 bg-forest bg-[url('/assets/images/city.svg')] rounded-t-lg">
        <h1 class="text-center leading-[5rem] font-bold text-white text-2xl">今回の目的地</h1>
      </div>
      <div class="w-full py-8">
        <p class="text-center text-6xl font-din font-extrabold text-forest"><span
            class="text-4xl font-bold text-black">〒</span>900<span
            class="font-bold text-4xl text-black align-[30%]">-</span>0021
        </p>
        <p class="text-skyblue text-center mt-3 text-3xl font-bold">沖縄県</p>
        <p class="text-center text-4xl font-bold mt-3 mb-8">那覇市泉崎</p>
        <SubmitButton :label="'OK'" :type="undefined" @click="hideDestinationModal" />
      </div>
    </div>
  </div>
</template>