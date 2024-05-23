<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import { relativeDate } from '@/utils/date.js';
import PageHeading from '@/Components/PageHeading.vue';
import Pill from '@/Components/Pill.vue';
import type { Post, PostMeta, PostTopic } from '@/@types';

type Props = {
  posts: { data: Array<Post>; meta: PostMeta };
  topics: Array<PostTopic>;
  selectedTopic?: {
    id: number;
    name: string;
    description: string;
  };
};

defineProps<Props>();
</script>

<template>
  <AppLayout>
    <Container>
      <div>
        <PageHeading
          v-text="selectedTopic ? selectedTopic.name : 'All posts'"
        />
        <p v-if="selectedTopic" class="mt-1 text-sm text-slate-600">
          {{ selectedTopic.description }}
        </p>

        <menu class="mt-3 flex space-x-2 overflow-x-auto pb-2 pt-1">
          <li>
            <Pill :href="route('posts.index')" :is-active="!selectedTopic"
              >All Posts
            </Pill>
          </li>
          <li v-for="topic in topics" :key="topic.id">
            <Pill
              :href="route('posts.index', { topic: topic.slug })"
              :is-active="topic.id === selectedTopic?.id"
            >
              {{ topic.name }}
            </Pill>
          </li>
        </menu>
      </div>

      <ul class="divide mt-4 divide-y divide-slate-300 hover:divide-dotted">
        <li
          v-for="post in posts.data"
          :key="post.id"
          class="flex flex-col items-baseline justify-between rounded-sm md:flex-row"
        >
          <Link
            :href="post.routes.show"
            class="group block rounded-md px-2 py-4 hover:bg-slate-200"
          >
            <span class="text-lg font-semibold group-hover:text-indigo-500">{{
              post.title
            }}</span>
            <span class="block pt-1 text-sm text-slate-600">
              Written {{ relativeDate(post.created_at) }} by
              <span class="font-semibold text-slate-800">
                {{ post.user.name }}
              </span>
            </span>
          </Link>

          <Pill :href="route('posts.index', { topic: post.topic.slug })"
            >{{ post.topic.name }}
          </Pill>
        </li>
      </ul>

      <Pagination :meta="posts.meta" :only="['posts']" />
    </Container>
  </AppLayout>
</template>
