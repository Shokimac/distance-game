<script setup lang="ts">
interface Props {
  num: number
}

const props = defineProps<Props>();

const { num } = props

const isNotFirst = num != 1;
</script>

<template>
  <div :class="{ 'mt-3': isNotFirst }">
    <div class="flex">
      <img :src="'assets/icons/map-pin-user-fill.svg'" alt="map-pin-user-fill">
      <label :for="`player${num}`">{{ `プレイヤー${num}` }}</label>
    </div>
    <input type="text" :name="`player${num}`" placeholder="プレイヤー名を入力してください"
      class="mt-3 bg-textbox border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
  </div>
</template>