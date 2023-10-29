<script setup lang="ts">
import PlayerRegistForm from './ViewParts/PlayerRegistForm.vue';
import { reactive, ref } from "vue";
interface RegistForm {
  num: number,
  isDisplay: boolean
}

const MAX_FORM_COUNT = 4;
const MIN_PLAYER = 2;
const isNotEnoughPlayers = ref(false);

const registForms: RegistForm[] = reactive([
  {
    num: 1,
    isDisplay: true
  },
  {
    num: 2,
    isDisplay: true
  }
]);

const addForm = (): void => {
  if (registForms.length < MAX_FORM_COUNT) {
    registForms.push({
      num: registForms.length + 1,
      isDisplay: true
    });
  }
}

const checkForm = (): void => {
  const pattern = '^[^ 　]*$';
  let form: HTMLInputElement | null;
  let validForms = 0;
  for (let i = 1; i <= MAX_FORM_COUNT; i++) {
    form = document.querySelector(`input[name="form${i}"]`);
    if (form && form.value && form.value.match(pattern)) {
      ++validForms;
    }
  }
  console.log(validForms);
  if (validForms < MIN_PLAYER) {
    isNotEnoughPlayers.value = true;
  } else {
    isNotEnoughPlayers.value = false;
  }
  return;
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
      <div class="h-6">
        <p v-show="isNotEnoughPlayers" class="text-center font-bold text-red-500 mt-2">プレイするには最低2名の登録が必要です</p>
      </div>
      <div class="mt-3 w-9/12 h-56 mx-auto">
        <form @submit.prevent="checkForm" method="post">
          <PlayerRegistForm v-for="(value, key) in registForms" :key="key" :num="value.num" v-show="value.isDisplay"
            :is-error="isNotEnoughPlayers" />
          <div class="w-full mt-8 flex justify-center">
            <div @click="addForm" v-show="!(registForms.length === MAX_FORM_COUNT)">
              <div
                class="w-9 h-9 bg-forest rounded-full flex justify-center text-white font-bold text-2xl cursor-pointer">+
              </div>
            </div>
          </div>
          <button class="bg-forest text-white py-3 px-8 font-bold rounded-full text-2xl block mx-auto mt-10 shadow-lg"
            type="submit">
            目的地を決める
          </button>
        </form>
      </div>
    </div>
  </div>
</template>