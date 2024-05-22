<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import { relativeDate } from '@/utils/date.js';
import PageHeading from '@/Components/PageHeading.vue';
import Pill from '@/Components/Pill.vue';

const props = defineProps({
  posts: {
    data: [
      {
        id: Number,
        title: String,
        body: String,
        created_at: Date,
        updated_at: Date,
        routes: [String],
        topic: {
          name: String,
          slug: String,
        },
      },
    ],
  },
  topics: [
    {
      id: String,
      name: String,
      slug: String,
    },
  ],
  selectedTopic: {
    name: String,
    description: String,
  },
});
</script>

<template>
  <AppLayout>
    <Container>
      <div>
        <PageHeading
          v-text="selectedTopic ? selectedTopic.name : 'All posts'"
        />
        <p v-if="selectedTopic" class="mt-1 text-slate-600 text-sm">
          {{ selectedTopic.description }}
        </p>

        <menu class="flex space-x-2 mt-3 overflow-x-auto pb-2 pt-1">
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

      <ul class="mt-4 divide-y divide divide-slate-300 hover:divide-dotted">
        <li
          v-for="post in posts.data"
          :key="post.id"
          class="flex justify-between items-baseline flex-col md:flex-row rounded-sm"
        >
          <Link
            :href="post.routes.show"
            class="block group px-2 py-4 rounded-md hover:bg-slate-200"
          >
            <span class="font-semibold text-lg group-hover:text-indigo-500">{{
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
