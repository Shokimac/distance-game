<script setup lang="ts">
import { ref } from 'vue'

const counter = ref(0)
</script>

<template>
  <div>
    <p>{{ counter }}</p>

    <button
      class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
      @click="counter += 10">
      クリックしてね
    </button>
  </div>
</template>