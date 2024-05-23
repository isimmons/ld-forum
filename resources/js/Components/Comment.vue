<script setup lang="ts">
import { relativeDate } from '@/utils/date.js';
import { Comment, CommentWithUser } from '@/@types';

type Props = {
  comment: CommentWithUser<Comment>;
  isEditing: boolean;
};

defineProps<Props>();

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
      <div class="prose prose-sm mt-1 max-w-none" v-html="comment.html"></div>

      <span class="block pt-1 text-xs text-slate-600">
        Written by
        <span
          class="text-sm font-semibold text-slate-600 first-letter:uppercase"
        >
          {{ comment.user.name }}
        </span>
        {{ relativeDate(comment.created_at as string) }}
      </span>
      <!-- actions -->
      <div class="mt-2 flex justify-end gap-5 empty:hidden">
        <form
          v-if="comment.can?.update && !isEditing"
          @submit.prevent="$emit('edit', comment.id)"
        >
          <button
            type="submit"
            class="font-mono text-sm text-emerald-600 hover:font-semibold"
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
            class="font-mono text-sm text-red-700 hover:font-semibold"
          >
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
