<script setup lang="ts">
import { ButtonHTMLAttributes, toRefs, watch, ref } from "vue"

interface Props extends /* @vue-ignore */ ButtonHTMLAttributes {
  label: string,
  isDisabled?: boolean,
}
const props = defineProps<Props>();
const { label, isDisabled } = toRefs(props)
const activeClass = ['bg-forest', 'text-white', 'py-3', 'px-8', 'font-bold', 'rounded-full', 'text-2xl', 'block', 'mx-auto', 'shadow-lg'];
const disabledClass = ['bg-gray-500', 'text-gray-300', 'py-3', 'px-8', 'font-bold', 'rounded-full', 'text-2xl', 'block', 'mx-auto', 'shadow-lg', 'disabled'];
</script>

<template>
  <button :class="isDisabled ? disabledClass : activeClass" :type="type">
    {{ label }}
  </button>
</template>