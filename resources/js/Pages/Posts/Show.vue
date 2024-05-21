<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/utils/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import {computed, onMounted, ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useConfirm} from "@/Composables/useConfirm.js";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";

const props = defineProps(['post', 'comments'])

onMounted(() => {
   const page = new URLSearchParams(window.location.search).get("page");
   if(page > 1 && props.comments.meta.links.length < 2)
       router.replace(location.href.replace(location.search, ''));
});

const commentForm = useForm({body: ''});

const { confirmation } = useConfirm();

const commentTextAreaRef = ref(null);
const commentTextAreaShouldBeFocused = ref(false);

const commentIdBeingEdited = ref(null);
const isEditing = ref(false);
const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));

const addComment = () => {
    if (commentForm.processing) return;

    return commentForm.post(route('posts.comments.store', props.post.id),
        {
            preserveScroll: true,
            onSuccess: () => commentForm.reset(),
        });
}

const scrollToComment = (id) => {
    document.getElementById(id).scrollIntoView();
}

const editComment = (commentId) => {
    isEditing.value = true;
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdited.value?.body;
    commentTextAreaRef.value?.focus();
}

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
    isEditing.value = false;
}


const updateComment = async () => {
    if (commentForm.processing) return;

    if( ! await confirmation('Are you sure you want to update your comment?') ) {
        setTimeout(() => commentTextAreaRef.value.focus(), 300);
        return;
    }


    return commentForm.put(route('comments.update', {
            comment: commentIdBeingEdited.value,
            page: props.comments.meta.current_page,
            updated_at: new Date()
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                scrollToComment(commentIdBeingEdited.value);
                cancelEditComment();
            }
        });
}

const deleteComment = async (commentId) => {

    if(! await confirmation('Are you sure you want to delete this comment?')) return

     router.delete(route('comments.destroy', {
        comment: commentId,
        page: props.comments.data.length > 1
            ? props.comments.meta.current_page
            : Math.max(props.comments.meta.current_page -1, 1)
    }), {
        preserveScroll: true
    })
};


</script>

<template>
    <AppLayout :title="post.title">
        <Container>
            <Pill :href="route('posts.index', { topic: post.topic.slug})">{{ post.topic.name }}</Pill>
            <PageHeading class="mt-2">{{ post.title }}</PageHeading>
            <span class="block mt-1 text-sm text-slate-600">Written by<span
                class="font-semibold text-slate-800">{{ ` ${post.user.name} ` }}</span>{{
                    relativeDate(post.created_at)
                }}</span>
            <article class="mt-6 prose prose-sm max-w-none" v-html="post.html" />

            <div class="mt-12">
                <h2 class="text-xl font-semibold">Comments</h2>

                <form v-if="$page.props.auth.user"
                      @submit.prevent="() => commentIdBeingEdited ? updateComment() : addComment()"
                      class="mt-4">
                    <div>
                        <InputLabel for="body"
                                    class="sr-only">Comment
                        </InputLabel>
                            <MarkdownEditor id="body"
                                      ref="commentTextAreaRef"
                                      v-model="commentForm.body"
                                      placeholder="What are you trying to say?"
                                      editorClass="min-h-[160px]"
                            />
                        <InputError :message="commentForm.errors.body" class="mt-1"/>
                    </div>
                    <div class="space-x-3">
                        <PrimaryButton type="submit"
                                       class="mt-3 disabled:bg-slate-500"
                                       :aria-disabled="commentForm.processing"
                                       v-text="commentIdBeingEdited ? 'Update Comment' : 'Add Comment'"
                        >
                        </PrimaryButton>
                        <SecondaryButton v-if="commentIdBeingEdited" @click="cancelEditComment"
                                         :aria-disabled="commentForm.processing"
                        >
                            Cancel Edit
                        </SecondaryButton>
                    </div>
                </form>

                <ul class="divide-y divide-slate-300 mt-4">
                    <li
                        :id="comment.id"
                        v-for="comment in comments.data"
                        :key="comment.id"
                        class="px-2 py-4"
                    >
                        <Comment @delete="deleteComment" @edit="editComment" :comment="comment" :isEditing="isEditing"/>
                    </li>
                </ul>

                <Pagination v-if="comments.meta.links.length > 1" :meta="comments.meta"
                            :only="['comments']"/>
            </div>
        </Container>
    </AppLayout>
</template>
