<script setup>
import { relativeDate } from '@/utils/date.js';

const props = defineProps(['comment', 'isEditing']);

const emit = defineEmits(['delete', 'edit']);
</script>

<template>
  <div class="sm:flex">
    <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
      <img
        :src="comment.user.profile_photo_url"
        :alt="`${comment.user.name} profile photo`"
        class="size-10 rounded-full"
      />
    </div>
    <div class="flex-1">
      <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>

      <span class="block pt-1 text-xs text-slate-600">
        Written by
        <span
          class="first-letter:uppercase font-semibold text-slate-600 text-sm"
        >
          {{ comment.user.name }}
        </span>
        {{ relativeDate(comment.created_at) }}
      </span>
      <!-- actions -->
      <div class="mt-2 flex justify-end gap-5 empty:hidden">
        <form
          v-if="comment.can?.update && !isEditing"
          @submit.prevent="$emit('edit', comment.id)"
        >
          <button
            type="submit"
            class="font-mono text-emerald-600 text-sm hover:font-semibold"
          >
            Edit
          </button>
        </form>
        <form
          v-if="comment.can?.delete && !isEditing"
          @submit.prevent="$emit('delete', comment.id)"
        >
          <button
            type="submit"
            class="font-mono text-red-700 text-sm hover:font-semibold"
          >
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
