<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { relativeDate } from "@/utils/date.js";
import Comment from "@/Components/Comment.vue";

const $props = defineProps(['post', 'comments'])

</script>

<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-sm text-slate-600">Written {{ relativeDate(post.created_at) }} by <span class="font-semibold text-slate-800">{{ post.user.name }}</span></span>
            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div class="mt-12">
                <h2 class="text-xl font-semibold">Comments</h2>

                <ul class="divide-y divide-slate-300 mt-4">
                    <li v-for="comment in comments.data"
                        :key="comment.id"
                        class="px-2 py-4"
                    >
                        <Comment :comment="comment" />
                    </li>
                </ul>

                <Pagination :meta="comments.meta" />
            </div>
        </Container>
    </AppLayout>
</template>
