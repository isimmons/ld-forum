<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import {isProductionEnv} from "@/utils/environment.js";

const postForm = useForm({
    'title': '',
    'body': '',
});
const createPost = () => postForm.post(route('posts.store'));

const autofill = async () => {
    if(isProductionEnv()) return;

    const response = await axios.get('/local/post-content');

    if(response.status === 200) {
        postForm.title = response.data.title;
        postForm.body = response.data.body;
    }

}
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
                        <MarkdownEditor v-model="postForm.body">
                            <template #toolbar="{ editor }">
                                <li v-if="! isProductionEnv()">
                                    <button @click="autofill"
                                            type="button"
                                            title="Autofill"
                                            class="px-3 py-2"
                                    >
                                        <i class="ri-article-line"></i>
                                    </button>
                                </li>
                            </template>
                        </MarkdownEditor>
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
