<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";

const postForm = useForm({
    'title': '',
    'body': '',
});

const createPost = () => postForm.post(route('posts.store'));
</script>

<template>
    <AppLayout title="Create a post">
        <Container>
            <h1 class="text-2xl font-bold">Create a post</h1>

            <form @submit.prevent="createPost" class="mt-6">
                <div class="flex flex-col space-y-3">
                    <div>
                        <InputLabel for="title"
                                    class="sr-only">Title
                        </InputLabel>
                        <TextInput id="title" v-model="postForm.title" class="w-full" />
                        <InputError :message="postForm.errors.title" class="mt-1"/>
                    </div>
                    <div>
                        <InputLabel for="body"
                                    class="sr-only">Body
                        </InputLabel>
                        <TextArea id="body" v-model="postForm.body" rows="25"  />
                        <InputError :message="postForm.errors.body" class="mt-1"/>
                    </div>
                    <div>
                        <PrimaryButton type="submit">Create Post</PrimaryButton>
                    </div>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>
