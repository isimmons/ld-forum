<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { relativeDate } from "@/utils/date.js";

defineProps(['posts'])

</script>

<template>
    <AppLayout>
        <Container>
            <ul class="divide-y divide divide-slate-300 hover:divide-dotted">
                <li v-for="post in posts.data"
                    :key="post.id"
                    class="rounded-sm"
                >
                    <Link :href="route('posts.show', post.id)" class="block group px-2 py-4 rounded-md hover:bg-slate-200">
                        <span class="font-semibold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="block pt-1 text-sm text-slate-600">
                            Written {{ relativeDate(post.created_at) }} by
                            <span class="font-semibold text-slate-800">
                                {{ post.user.name }}
                            </span>
                        </span>
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" :only="['posts']" />
        </Container>
    </AppLayout>
</template>
