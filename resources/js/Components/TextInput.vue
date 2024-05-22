<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string>();

const input = ref<HTMLInputElement>(null);

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    ref="input"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    v-model="model"
  />
</template>
