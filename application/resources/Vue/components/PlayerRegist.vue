<script setup lang="ts">
import PlayerRegistForm from "./ViewParts/PlayerRegistForm.vue";
import SubmitButton from "./ViewParts/SubmitButton.vue";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { ApiModule } from "../../ts/api/ApiModule";
interface RegistForm {
	num: number;
	isDisplay: boolean;
}

const api = new ApiModule();
const router = useRouter();

const MAX_FORM_COUNT = 4;
const MIN_PLAYER = 2;
const isNotEnoughPlayers = ref(false);
const errorMessage = ref("");

const registForms: RegistForm[] = reactive([
	{
		num: 1,
		isDisplay: true,
	},
	{
		num: 2,
		isDisplay: true,
	},
]);

const addForm = (): void => {
	if (registForms.length < MAX_FORM_COUNT) {
		registForms.push({
			num: registForms.length + 1,
			isDisplay: true,
		});
	}
};

const execRegist = async (): Promise<void> => {
	let form: HTMLInputElement | null;
	const gamePlayers: string[] = [];
	for (let i = 1; i <= MAX_FORM_COUNT; i++) {
		form = document.querySelector(`input[name="form${i}"]`);
		if (form && form.value) {
			gamePlayers.push(form.value);
		}
	}
	if (checkForm(gamePlayers)) {
		try {
			const { value: game, error } = await api.createGame(gamePlayers);
			if (game) {
				router.push(`/game/${game.id}`);
			}
			if (error) {
				errorMessage.value =
					"ゲームの登録に失敗しました。お手数ですが、もう一度お試しください。";
			}
		} catch (error) {
			errorMessage.value =
				"通信に失敗しました。お手数ですが、もう一度お試しください。";
		}
	}
};

const checkForm = (gamePlayers: string[]): boolean => {
	if (gamePlayers.length < MIN_PLAYER) {
		isNotEnoughPlayers.value = true;
		errorMessage.value = "最低2名のユーザー登録が必要です。";
		return false;
	} else {
		isNotEnoughPlayers.value = false;
		return true;
	}
};
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
        <p v-show="isNotEnoughPlayers" class="text-center font-bold text-red-500 mt-2">{{ errorMessage }}</p>
      </div>
      <div class="mt-3 w-9/12 mx-auto">
        <form @submit.prevent="execRegist" method="post">
          <PlayerRegistForm v-for="(value, key) in registForms" :key="key" :num="value.num" v-show="value.isDisplay"
            :is-error="isNotEnoughPlayers" />
          <div class="w-full mt-8 flex justify-center">
            <div @click="addForm" v-show="!(registForms.length === MAX_FORM_COUNT)">
              <div
                class="w-9 h-9 bg-forest rounded-full flex justify-center text-white font-bold text-2xl cursor-pointer">+
              </div>
            </div>
          </div>
          <div class="mt-4 mb-10">
            <SubmitButton :type="'submit'" :label="'目的地を決める'" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>