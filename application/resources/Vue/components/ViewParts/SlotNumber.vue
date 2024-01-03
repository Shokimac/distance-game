<script setup lang="ts">
import { toRefs, watch } from "vue"
interface Props {
  index: number,
  number: number,
  marginClass: string,
  rotateSlot: boolean,
  type: 'head' | 'bottom',
}

interface Emits {
  (event: 'confirmNum', number: number, index: number, type: 'head' | 'bottom'): void;
}

const props = defineProps<Props>()
const { number, marginClass, rotateSlot, index, type } = toRefs(props)
let intervalId = 0;

const emits = defineEmits<Emits>()

const stopSlot = (() => {
  clearInterval(intervalId);
  emits('confirmNum', number.value, index.value, type.value);
})

const changeNum = ((): void => {
  number.value = Math.floor(Math.random() * 10)
})

watch(rotateSlot, () => {
  if (rotateSlot.value) {
    intervalId = setInterval(changeNum, 10)
  }
})

</script>

<template>
  <div
    :class="['w-2/12', 'h-20', 'border-forest', 'border-2', 'rounded-lg', 'flex', 'items-center', 'justify-center', marginClass]"
    @click="stopSlot">
    <p class="text-4xl text-forest font-extrabold">{{ number }}</p>
  </div>
</template>