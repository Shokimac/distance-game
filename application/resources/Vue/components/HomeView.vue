<!-- eslint-disable prettier/prettier -->
<script setup lang="ts">
import { ref } from "vue";

const displayModal = ref(true);

function onShowModal() {
  displayModal.value = displayModal.value ? false : true;
}
</script>

<template>
  <div class="flex justify-center min-h-screen absolute">
    <div class="w-11/12">
      <img src="../../images/image/main_icon.svg" class="w-full mt-20 mx-auto" />
      <h1 class="mt-16 text-white flex align-center justify-center font-din text-3xl 
      before:content-[''] before:h-px before:w-16 before:bg-white before:mr-4
      after:content-[''] after:h-px after:w-16 after:bg-white after:ml-4">DISTANCE GAME</h1>
      <button class="bg-forest text-white py-3 px-8 font-bold rounded-full text-2xl block mx-auto mt-10">ゲームを始める</button>
      <button class="text-white font-bold text-lg block mx-auto mt-9" @click="onShowModal">
        <img src="../../images/icon/information-fill.svg" alt="ゲームの遊び方" class="inline">
        遊び方について
      </button>
    </div>
  </div>
  <div v-show="displayModal" class="w-full min-h-screen bg-shadow relative top-0 left-0 flex justify-center items-center">
    <div class="w-11/12 bg-white rounded-lg py-10 absolute">
      <div class="bg-forest w-24 h-24 rounded-full relative top-0 left-5">01</div>
      <img src="../../images/image/undraw_select_player_64ca1.svg" alt="info1" class="mx-auto">
      <p class="text-center">Distance Gameは<br>最大4人までプレイが可能です！<br>お友達や家族、みんなで遊べるゲームです<br>さぁ、プレイヤーを見つけて<br>ゲームを開始しよう</p>
    </div>
  </div>
</template>
