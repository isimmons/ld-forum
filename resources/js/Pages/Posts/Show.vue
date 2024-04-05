<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/utils/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps(['post', 'comments'])

const commentForm = useForm({body: ''});
const addComment = () => {
    if(commentForm.processing) return;

    return commentForm.post(route('posts.comments.store', props.post.id),
        {
            preserveScroll: true,
            onSuccess: () => commentForm.reset(),
        });
}

</script>

<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-sm text-slate-600">Written by<span class="font-semibold text-slate-800">{{ ` ${post.user.name} ` }}</span>{{
                    relativeDate(post.created_at)
                }}</span>
            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div class="mt-12">
                <h2 class="text-xl font-semibold">Comments</h2>

                <form v-if="$page.props.auth.user" @submit.prevent="addComment"
                      class="mt-4">
                    <div>
                        <InputLabel for="body"
                                    class="sr-only">Comment
                        </InputLabel>
                        <TextArea id="body"
                                  v-model="commentForm.body"
                        />
                        <InputError :message="commentForm.errors.body" class="mt-1" />
                    </div>

                    <PrimaryButton type="submit"
                                   class="mt-3 disabled:bg-slate-500"
                                   :aria-disabled="commentForm.processing"
                    >
                        Add Comment
                    </PrimaryButton>
                </form>

                <ul class="divide-y divide-slate-300 mt-4">
                    <li v-for="comment in comments.data"
                        :key="comment.id"
                        class="px-2 py-4"
                    >
                        <Comment :comment="comment"/>
                    </li>
                </ul>

                <Pagination v-if="comments.meta.links.length > 1" :meta="comments.meta"
                            :only="['comments']"/>
            </div>
        </Container>
    </AppLayout>
</template>