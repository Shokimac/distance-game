<script setup lang="ts">
import SubmitButton from './SubmitButton.vue';
import SlotNumber from './SlotNumber.vue';
import { ref } from 'vue';
import { ApiModule } from '../../../ts/api/ApiModule';
import { Location } from '../../../ts/types/index.d'

interface Emits {
  (event: 'prickPin', location: Location): void
}
const emits = defineEmits<Emits>()

const api = new ApiModule()

const headCodeList = ref([0, 0, 0])
const headRotateList = ref([false, false, false])
const bottomCodeList = ref([0, 0, 0, 0])
const bottomRotateList = ref([false, false, false, false])
const isDisabled = ref(false)
const location = ref(<Location>{})

const startSlot = ((): void => {
  headRotateList.value.forEach((tmp, index) => {
    headRotateList.value[index] = true;
  })
  bottomRotateList.value.forEach((tmp, index) => {
    bottomRotateList.value[index] = true;
  })
  isDisabled.value = true
})

const confirmNum = ((number: number, index: number, type: 'head' | 'bottom'): void => {
  if (type === 'head') {
    headCodeList.value.splice(index, 1, number);
    headRotateList.value[index] = false
  } else {
    bottomCodeList.value.splice(index, 1, number);
    bottomRotateList.value[index] = false
  }

  if (!headRotateList.value.includes(true) && !bottomRotateList.value.includes(true) && isDisabled.value) {
    getLocation();
  }
})

async function getLocation() {
  const postalCode = headCodeList.value.join('') + bottomCodeList.value.join('')

  const { value, error } = await api.getLocationByPostalCode(postalCode);
  location.value = value
}

const prickPin = ((): void => {
  emits('prickPin', location.value);
})

</script>

<template>
  <div class="w-full h-screen z-10 bg-shadow absolute top-0 left-0 flex justify-center items-center">
    <div class="w-full py-8 mx-4 bg-white rounded-lg z-20">
      <div class="mb-5 mx-auto">
        <p class="text-center">各スロットをタップして止めて</p>
        <p class="text-center">ピンを刺す場所を決定してください</p>
      </div>
      <div class="flex mx-2 justify-between mb-4 overflow-y-hidden">
        <SlotNumber v-for="(number, index) in headCodeList" :index="index" :number="number" :key="index" :type="'head'"
          :margin-class="index === 1 ? 'mx-1' : ''" :rotate-slot="headRotateList[index]" @confirm-num="confirmNum" />
        <div class="mx-1 h-20 flex justify-center items-center">
          <p class="text-4xl font-bold">-</p>
        </div>
        <SlotNumber v-for="(number, index) in bottomCodeList" :index="index" :number="number" :key="index"
          :type="'bottom'" :margin-class="(index !== 0 ? 'ml-1' : '')" :rotate-slot="bottomRotateList[index]"
          @confirm-num="confirmNum" />
      </div>
      <div class="mb-4 mx-auto">
        <SubmitButton label="回す" :type="undefined" @click.once="startSlot" :is-disabled="isDisabled" />
      </div>
      <div class="font-bold text-center mx-auto" v-if="location.postal_code">
        <span class="text-2xl">〒</span>
        <span class="text-forest text-5xl font-din">{{ location.postal_code.slice(0, 3) }}</span>
        <span class="text-5xl font-bold">-</span>
        <span class="text-forest text-5xl font-din">{{ location.postal_code.slice(-4) }}</span>
        <div class="text-center mx-auto my-2">
          <p class="text-3xl text-forest">{{ location.prefecture }}</p>
          <p class="text-4xl font-bold mt-2">{{ location.city }} {{ location.town }}</p>
        </div>
        <div class="my-4">
          <SubmitButton label="マップにピンを刺す" :type="undefined" @click="prickPin" />
        </div>
      </div>
    </div>
  </div>
</template>