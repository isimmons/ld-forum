<script setup lang="ts">
type Props = {
  type: 'button' | 'reset' | 'submit';
};

withDefaults(defineProps<Props>(), {
  type: 'button',
});
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
  >
    <slot />
  </button>
</template>
