<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { relativeDate } from "@/utils/date.js";

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
                }
            }
        ]
    }
});
</script>

<template>
    <AppLayout>
        <Container>
            <ul class="divide-y divide divide-slate-300 hover:divide-dotted">
                <li v-for="post in posts.data"
                    :key="post.id"
                    class=" flex justify-between items-baseline flex-col md:flex-row rounded-sm"
                >
                    <Link :href="post.routes.show" class="block group px-2 py-4 rounded-md hover:bg-slate-200">
                        <span class="font-semibold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="block pt-1 text-sm text-slate-600">
                            Written {{ relativeDate(post.created_at) }} by
                            <span class="font-semibold text-slate-800">
                                {{ post.user.name }}
                            </span>
                        </span>
                    </Link>
                    <Link href="/" class="mb-2 rounded-full py-0.5 px-2 bg-emerald-100 text-emerald-900 text-sm font-semibold border border-emerald-900 hover:bg-emerald-500 hover:text-white">
                        {{ post.topic.name }}
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" :only="['posts']" />
        </Container>
    </AppLayout>
</template>
