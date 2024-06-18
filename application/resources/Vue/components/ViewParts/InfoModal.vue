<script setup lang="ts">
import { toRefs } from "vue";
interface Props {
	displayInfoModal: boolean;
	infoNum: number;
	imgFileName: string;
	infoBody: string;
	displayPrevButton: boolean;
	displayNextButton: boolean;
}

const props = defineProps<Props>();
const {
	displayInfoModal,
	infoNum,
	imgFileName,
	infoBody,
	displayPrevButton,
	displayNextButton,
} = toRefs(props);

interface Emits {
	(event: "showNextInfoModal", key: number): void;
	(event: "showPrevInfoModal", key: number): void;
	(event: "hideInfoModal", key: number): void;
}
const emit = defineEmits<Emits>();
function showNextInfoModal() {
	emit("showNextInfoModal", infoNum.value);
}
function showPrevInfoModal() {
	emit("showPrevInfoModal", infoNum.value);
}
function hideInfoModal() {
	emit("hideInfoModal", infoNum.value);
}
</script>
<template>
  <div v-show="displayInfoModal"
    class="w-full min-h-screen bg-shadow relative top-0 left-0 flex justify-center items-center">
    <div class="w-11/12 bg-white rounded-lg py-16 relative">
      <div
        class="bg-forest w-24 h-24 rounded-full absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center text-white">
        {{ "0" + (infoNum + 1) }}
      </div>
      <img :src="`assets/images/${imgFileName}`" :alt="'info' + infoNum" class="mx-auto">
      <div class="w-28 h-0.5 bg-forest rotate-[80deg] absolute top-3/4 -left-[12%]"></div>
      <div class="mt-5 h-32 flex justify-center items-center text-center">
        <p v-html="infoBody"></p>
      </div>
      <div class="w-28 h-0.5 bg-forest -rotate-[80deg] absolute top-3/4 -right-[12%]"></div>
      <button class="text-forest text-lg font-bold block absolute bottom-4 left-4" v-if="displayPrevButton"
        @click="showPrevInfoModal">前へ</button>
      <button class="text-forest text-lg font-bold block absolute bottom-4 left-1/2 -translate-x-1/2"
        @click="hideInfoModal">閉じる</button>
      <button class="text-forest text-lg font-bold block absolute bottom-4 right-4" v-if="displayNextButton"
        @click="showNextInfoModal">次へ</button>
    </div>
  </div>
</template>