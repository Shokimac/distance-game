<!-- eslint-disable prettier/prettier -->
<script setup lang="ts">
import { reactive } from "vue";
import InfoModal from "./ViewParts/InfoModal.vue"
import SubmitButton from "./ViewParts/SubmitButton.vue";
import { useRouter } from "vue-router"

interface playInfoInterface {
  imgFileName: string,
  infoBody: string,
  display: boolean
}
const playInfo: playInfoInterface[] = reactive([
  {
    imgFileName: 'info1.svg',
    infoBody: '<span class="text-forest font-bold">Distance Game</span>は<br>最大4人までプレイが可能です！<br><span class="text-forest font-bold">お友達や家族、みんなで遊べるゲームです</span><br>さぁ、プレイヤーを見つけて<br>ゲームを開始しよう',
    display: false
  },
  {
    imgFileName: 'info2.svg',
    infoBody: 'プレイヤー名を入力して<br>ゲームをスタートしたら目的地が<br>ランダムに設定されます！',
    display: false
  },
  {
    imgFileName: 'info3.svg',
    infoBody: '目的地が決まった後は<br>各プレイヤー順番にスロットを回して<br>郵便番号を決めます！',
    display: false
  },
  {
    imgFileName: 'info4.svg',
    infoBody: 'スロットで決まった郵便番号の地域から<br>目的地までの直線距離が計測されます！<br><span class="text-forest font-bold">目的地から最も短い距離を出した<br>プレイヤーが優勝！</span>',
    display: false
  },
]);

const showNextInfoModal = (key: number): void => {
  playInfo[key].display = false;
  playInfo[key + 1].display = true;
}
const showPrevInfoModal = (key: number): void => {
  playInfo[key].display = false;
  playInfo[key - 1].display = true;
}
const showInfoModal = (): void => {
  playInfo[0].display = true;
}
const hideInfoModal = (key: number): void => {
  playInfo[key].display = false;
}

const router = useRouter();

const toPlayerRegist = (): void => {
  router.push("/playerregist")
}
</script>

<template>
  <div class="flex justify-center min-h-screen absolute bg-skyblue">
    <div class="w-11/12">
      <img :src="'assets/images/main_image.svg'" alt="main image" class="w-full mt-20 mx-auto" />
      <h1 class="mt-16 mb-10 text-white flex align-center justify-center font-din text-3xl
      before:content-[''] before:h-px before:w-16 before:bg-white before:mr-4
      after:content-[''] after:h-px after:w-16 after:bg-white after:ml-4">DISTANCE GAME</h1>
      <SubmitButton :type="undefined" :label="'ゲームを始める'" @click="toPlayerRegist" />
      <button class="text-white font-bold text-lg block mx-auto mt-9" @click="showInfoModal">
        <img :src="'assets/icons/information-fill.svg'" alt="ゲームの遊び方" class="inline">
        遊び方について
      </button>
    </div>
  </div>
  <InfoModal v-for="(value, key) in playInfo" :key="key" :info-num="key" :display-info-modal="value.display"
    :img-file-name="value.imgFileName" :info-body="value.infoBody" :display-prev-button="key != 0"
    :display-next-button="(key + 1) != playInfo.length" v-on:show-next-info-modal="showNextInfoModal"
    v-on:show-prev-info-modal="showPrevInfoModal" v-on:hide-info-modal="hideInfoModal" />
</template>
