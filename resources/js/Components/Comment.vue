<script setup>
import { relativeDate } from "@/utils/date.js";

defineProps(['comment']);
</script>

<template>
    <div class="sm:flex">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="comment.user.profile_photo_url"
                 :alt="`${comment.user.name} profile photo`"
                 class="size-10 rounded-full"
            />
        </div>
        <div>
            <p class="mt-1 break-all">{{ comment.body }}</p>
            <span class="block pt-1 text-xs text-slate-600">
                Written by
                <span class="first-letter:uppercase font-semibold text-slate-600 text-sm">
                    {{ comment.user.name }}
                </span>
                {{ relativeDate(comment.created_at) }}
            </span>
        </div>
    </div>
</template>
