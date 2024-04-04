<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1">
            <Link :href="previousUrl"
               class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                <ArrowLongLeftIcon class="mr-3 h-5 w-5 text-gray-400"
                                   aria-hidden="true"/>
                Previous
            </Link>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <Link v-for="link in meta.links"
                  :href="link.url"
                  v-html="link.label"
                  class="inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium"
                  :class="{
                           'border-indigo-500 text-indigo-600' : link.active,
                           'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': !link.active
                       }"
            ></Link>
        </div>
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <Link :href="nextUrl"
               class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                Next
                <ArrowLongRightIcon class="ml-3 h-5 w-5 text-gray-400"
                                    aria-hidden="true"/>
            </Link>
        </div>
    </nav>
</template>

<script setup>
import {ArrowLongLeftIcon, ArrowLongRightIcon} from '@heroicons/vue/20/solid'

import { Link } from '@inertiajs/vue3';
import {computed} from "vue";

const props = defineProps(['meta']);

const previousUrl = computed(() => props.meta.links.shift().url);
const nextUrl = computed(() => props.meta.links.pop().url);

</script>
