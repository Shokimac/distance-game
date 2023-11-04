<script setup lang="ts">
import { ButtonHTMLAttributes } from "vue"

interface Props extends /* @vue-ignore */ ButtonHTMLAttributes {
  label: string,
}

defineProps<Props>();

</script>

<template>
  <button class="bg-forest text-white py-3 px-8 font-bold rounded-full text-2xl block mx-auto shadow-lg" :type="type">
    {{ label }}
  </button>
</template>