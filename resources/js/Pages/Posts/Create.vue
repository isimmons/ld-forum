<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import { isProductionEnv } from '@/utils/environment.js';
import PageHeading from '@/Components/PageHeading.vue';

const props = defineProps(['topics']);

const postForm = useForm({
  title: '',
  topic_id: props.topics[0].id,
  body: '',
});
const createPost = () => postForm.post(route('posts.store'));

const autofill = async () => {
  if (isProductionEnv()) return;

  const response = await axios.get('/local/post-content');

  if (response.status === 200) {
    postForm.title = response.data.title;
    postForm.body = response.data.body;
  }
};
</script>

<template>
  <AppLayout title="Create a post">
    <Container>
      <PageHeading>Create a Post</PageHeading>

      <form @submit.prevent="createPost" class="mt-6">
        <div class="flex flex-col space-y-3">
          <div>
            <InputLabel for="title" class="sr-only">Title </InputLabel>
            <TextInput id="title" v-model="postForm.title" class="w-full" />
            <InputError :message="postForm.errors.title" class="mt-1" />
          </div>

          <div>
            <InputLabel for="topic_id">Select a Topic</InputLabel>
            <select
              v-model="postForm.topic_id"
              name="topic_id"
              id="topic_id"
              class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            >
              <option v-for="topic in topics" :key="topic.id" :value="topic.id">
                {{ topic.name }}
              </option>
            </select>
            <InputError :message="postForm.errors.topic_id" class="mt-1" />
          </div>

          <div>
            <InputLabel for="body" class="sr-only">Body </InputLabel>
            <MarkdownEditor v-model="postForm.body" editorClass="min-h-[512px]">
              <template #toolbar="{ editor }">
                <li v-if="!isProductionEnv()">
                  <button
                    @click="autofill"
                    type="button"
                    title="Autofill"
                    class="px-3 py-2"
                  >
                    <i class="ri-article-line"></i>
                  </button>
                </li>
              </template>
            </MarkdownEditor>
            <InputError :message="postForm.errors.body" class="mt-1" />
          </div>
          <div>
            <PrimaryButton type="submit">Create Post</PrimaryButton>
          </div>
        </div>
      </form>
    </Container>
  </AppLayout>
</template>
