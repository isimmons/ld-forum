<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

type Props = {
  href?: string;
  as?: 'a' | 'button';
};

withDefaults(defineProps<Props>(), {
  href: '#',
  as: 'a',
});
</script>

<template>
  <div>
    <button
      v-if="as === 'button'"
      type="submit"
      class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
    >
      <slot />
    </button>

    <a
      v-else-if="as === 'a'"
      :href="href"
      class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
    >
      <slot />
    </a>

    <Link
      v-else
      :href="href"
      class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
    >
      <slot />
    </Link>
  </div>
</template>
