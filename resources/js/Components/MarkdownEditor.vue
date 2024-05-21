<script setup lang="ts">
import {EditorContent, useEditor} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";
import {Link} from "@tiptap/extension-link";
import {Placeholder} from "@tiptap/extension-placeholder";
import {onMounted, watch} from "vue";
import {Markdown} from "tiptap-markdown";
import 'remixicon/fonts/remixicon.css';

const props = defineProps({
    editorClass: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: null
    },
});

const model = defineModel();

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3, 4]
            },
            code: false,
            codeBlock: false,
        }),
        Markdown,
        Link,
        Placeholder.configure({ placeholder: props.placeholder }),
    ],
    editorProps: {
        attributes: {
            class: `prose prose-sm max-w-none py-1.5 px-3 min-h-[512px] ${props.editorClass}`,
        },
    },
    onUpdate: () => model.value = editor.value?.storage.markdown.getMarkdown(),
});

defineExpose({ focus: () => editor.value.commands.focus() });

onMounted(() => {
    watch(model, (value) => {
        if (value === editor.value?.storage.markdown.getMarkdown()) return;

        editor.value?.commands.setContent(value);
    }, {immediate: true});
});



const promptUserForHref = () => {
    if (editor.value?.isActive('link')) {
        return editor.value?.chain().unsetLink().run();
    }

    const href = prompt('Where do you want to link to?');

    if (! href) {
        return editor.value?.chain().focus().run();
    }

    return editor.value?.chain().focus().setLink({ href }).run();
};
</script>

<template>
    <div v-if="editor" class="bg-white rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
        <menu class="flex divide-x divide-slate-200 border-b border-slate-200">
            <li>
                <button @click="() => editor.chain().focus().toggleBold().run()"
                        type="button"
                        title="Bold"
                        class="px-3 py-2 rounded-tl-md"
                        :class="[editor.isActive('bold') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-bold"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleItalic().run()"
                        type="button"
                        title="Italic"
                        class="px-3 py-2"
                        :class="[editor.isActive('italic') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleStrike().run()"
                        type="button"
                        title="Strike Through"
                        class="px-3 py-2"
                        :class="[editor.isActive('strike') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBlockquote().run()"
                        type="button"
                        title="Blockquote"
                        class="px-3 py-2"
                        :class="[editor.isActive('blockquote') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBulletList().run()"
                        type="button"
                        title="Bullet List"
                        class="px-3 py-2"
                        :class="[editor.isActive('bulletList') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleOrderedList().run()"
                        type="button"
                        title="Numeric List"
                        class="px-3 py-2"
                        :class="[editor.isActive('orderedList') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button @click="promptUserForHref"
                        type="button"
                        title="Add Link"
                        class="px-3 py-2"
                        :class="[editor.isActive('link') ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-link"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 2 }).run()"
                        type="button"
                        title="Heading Level 1"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 2 }) ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-h-1"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 3 }).run()"
                        type="button"
                        title="Heading Level 2"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 3 }) ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-h-2"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 4 }).run()"
                        type="button"
                        title="Heading Level 3"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 4 }) ? 'bg-slate-600 text-slate-200' : 'hover:bg-slate-300']"
                >
                    <i class="ri-h-3"></i>
                </button>
            </li>

            <slot name="toolbar" :editor="editor" />

        </menu>
        <EditorContent :editor="editor"/>
    </div>
</template>

<style scoped lang="postcss">
:deep(.tiptap p.is-editor-empty:first-child::before) {
    @apply text-slate-400 float-left h-0 pointer-events-none content-[attr(data-placeholder)];
}
</style>
