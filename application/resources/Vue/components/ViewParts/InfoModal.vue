<script setup lang="ts">
interface Props {
  infoNum: string,
  imgFileName: string,
  infoBody: string,
}

const props = defineProps<Props>();
const { infoNum, imgFileName, infoBody } = props
</script>
<template>
  <div class="w-11/12 bg-white rounded-lg py-16 relative">
    <div
      class="bg-forest w-24 h-24 rounded-full absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center text-white">
      {{ infoNum }}
    </div>
    <img :src="`assets/images/${imgFileName}`" :alt="'info' + infoNum" class="mx-auto">
    <div class="w-28 h-0.5 bg-forest rotate-[80deg] absolute top-3/4 -left-[12%]"></div>
    <p class="text-center mt-5" v-html="infoBody">
    </p>
    <div class="w-28 h-0.5 bg-forest -rotate-[80deg] absolute top-3/4 -right-[12%]"></div>
  </div>
</template>