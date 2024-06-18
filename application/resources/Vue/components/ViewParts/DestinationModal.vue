<script setup lang="ts">
import { toRefs } from "vue";
import SubmitButton from "./SubmitButton.vue";
import { Location } from "../../../ts/types";

interface Props {
	location: Location;
}

const props = defineProps<Props>();
const location = props.location;
const topPostalCode = location.postal_code.substring(0, 3);
const bottomPostalCode = location.postal_code.substring(3, 7);

interface Emits {
	(event: "hideDestinationModal"): void;
}
const emit = defineEmits<Emits>();

const hideDestinationModal = () => {
	emit("hideDestinationModal");
};
</script>

<template>
  <div class="w-full h-screen z-10 bg-shadow absolute top-0 left-0 flex justify-center items-center">
    <div class="w-11/12 bg-white rounded-lg z-20">
      <div class="w-full h-20 bg-forest bg-[url('/assets/images/city.svg')] rounded-t-lg">
        <h1 class="text-center leading-[5rem] font-bold text-white text-2xl">今回の目的地</h1>
      </div>
      <div class="w-full py-8">
        <p class="text-center text-6xl font-din font-extrabold text-forest"><span
            class="text-4xl font-bold text-black">〒</span>{{ topPostalCode }}<span
            class="font-bold text-4xl text-black align-[30%]">-</span>{{ bottomPostalCode }}
        </p>
        <p class="text-skyblue text-center mt-3 text-3xl font-bold">{{ location.prefecture }}</p>
        <p class="text-center text-4xl font-bold mt-3 mb-8">{{ location.city }} {{ location.town }}</p>
        <SubmitButton :label="'OK'" :type="undefined" @click="hideDestinationModal" />
      </div>
    </div>
  </div>
</template>