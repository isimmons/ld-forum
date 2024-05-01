<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true
    },
    isActive: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <Link
        :href="href"
        class="whitespace-nowrap mb-2 rounded-full py-0.5 px-2 bg-emerald-100 text-emerald-900 text-sm font-semibold border border-emerald-900 hover:bg-emerald-500 hover:text-white"
        :class="{ 'bg-emerald-500 text-white' : isActive }"
    >
        <slot></slot>
    </Link>
</template>
