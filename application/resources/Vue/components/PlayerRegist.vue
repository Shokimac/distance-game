<script setup lang="ts">
import PlayerRegistForm from './ViewParts/PlayerRegistForm.vue';
import { reactive } from "vue";
interface RegistForm {
  num: number,
  isDisplay: boolean
}

const registForms: RegistForm[] = reactive([
  {
    num: 1,
    isDisplay: true
  },
  {
    num: 2,
    isDisplay: true
  },
  {
    num: 3,
    isDisplay: false
  },
  {
    num: 4,
    isDisplay: false
  },
]);

const addForm = (): void => {
  if (registForms[2].isDisplay) {
    registForms[3].isDisplay = true;
  } else {
    registForms[2].isDisplay = true;
  }
}

</script>

<template>
  <div class="pt-20 w-full min-h-screen">
    <div class="w-28 h-28 mx-auto">
      <img :src="'assets/images/earth.svg'" alt="earth image" class="w-full mx-auto">
    </div>
    <div class="w-full mt-5">
      <p class="text-center font-extrabold text-xl">プレイヤー名を入力してください</p>
      <p class="text-center font-bold mt-2">（最大4人までプレイ可能）</p>
      <div class="mt-5 w-9/12 h-56 mx-auto">
        <PlayerRegistForm v-for="(value, key) in registForms" :key="key" :num="value.num" v-show="value.isDisplay" />
        <div class="w-full mt-8 flex justify-center">
          <button @click="addForm" v-show="!registForms[3].isDisplay">
            <div class="w-9 h-9 bg-forest rounded-full flex justify-center text-white font-bold text-2xl">+</div>
          </button>
        </div>
        <button
          class="bg-forest text-white py-3 px-8 font-bold rounded-full text-2xl block mx-auto mt-10 shadow-lg">目的地を決める
        </button>
      </div>
    </div>
  </div>
</template>