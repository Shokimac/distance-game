<script setup lang="ts">
import { toRefs } from "vue";
interface Props {
	num: number;
	isError: boolean;
}

const props = defineProps<Props>();

const { num } = props;
const { isError } = toRefs(props);

const isNotFirst = num != 1;
</script>

<template>
  <div :class="{ 'mt-3': isNotFirst }">
    <div class="flex">
      <img :src="'assets/icons/map-pin-user-fill.svg'" alt="map-pin-user-fill">
      <label :for="`player${num}`">{{ `プレイヤー${num}` }}</label>
    </div>
    <input type="text" :name="`form${num}`" placeholder="プレイヤー名を入力してください"
      :class="{ 'mt-3 bg-textbox border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5': true, 'placeholder-red-500 border-red-500': isError }">
  </div>
</template>