<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import { inject } from "@vue/runtime-core";
import AuthenticatedHeaderLayout from "@/Layouts/AuthenticatedHeaderLayout.vue";
const route = inject("route");
defineProps({
    usersBlogs: {
        type: Object,
    },
});
const deleteForm = useForm({
    blogId: null,
});
let updateBlog = reactive({
    updateBlogStateValue: false,
    updateForm: useForm({
        id: null,
        title: null,
        description: null,
    }),
    setUpdateBlogState(blogId, blogTitle, blogDescription) {
        this.updateBlogStateValue = true;
        this.updateForm.id = blogId;
        this.updateForm.title = blogTitle;
        this.updateForm.description = blogDescription;
    },
});
</script>
<script>
export default {
    methods: {
        deleteBlog(blogId, deleteForm) {
            deleteForm.blogId = blogId;
            deleteForm.delete(route("blog-delete"));
        },
    },
};
</script>
<template>
    <div class="min-h-screen bg-gray-100">
        <AuthenticatedHeaderLayout></AuthenticatedHeaderLayout>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <h1 class="text-4xl">Your Blogs</h1>
                        <div class="w-3/5 my-0 mx-auto flex flex-col gap-y-4">
                            <div v-if="updateBlog.updateBlogStateValue">
                                <form
                                    class="grid w-72 gap-4 mt-4 mx-6"
                                    @submit.prevent="
                                        updateBlog.updateForm.patch(
                                            route('blog-update')
                                        );
                                        updateBlog.updateBlogStateValue = false;
                                    "
                                >
                                    <label for="title">Title:</label>
                                    <input
                                        v-model="updateBlog.updateForm.title"
                                        id="title"
                                        type="text"
                                    />
                                    <label for="description"
                                        >Description:</label
                                    >
                                    <input
                                        v-model="
                                            updateBlog.updateForm.description
                                        "
                                        id="description"
                                        type="text"
                                    />

                                    <button
                                        :disabled="
                                            updateBlog.updateForm.processing
                                        "
                                        type="submit"
                                    >
                                        Submit
                                    </button>
                                </form>
                            </div>
                            <div
                                v-else
                                v-for="(blog, index) in usersBlogs"
                                :key="index"
                            >
                                <div>
                                    <h2 class="my-2 text-2xl">
                                        <b>{{ blog.title }}</b>
                                    </h2>
                                    <div class="my-4">
                                        <span
                                            >Posted by:{{
                                                blog.user.name
                                            }}</span
                                        >
                                    </div>
                                </div>
                                <div>{{ blog.description }}</div>
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold mb-6">
                                        Comments
                                    </h3>
                                    <ul>
                                        <li
                                            v-for="(
                                                comment, index
                                            ) in blog.comments"
                                            :key="index"
                                        >
                                            <span class="mr-2 font-bold">{{
                                                comment.user.name
                                            }}</span>
                                            <span>
                                                {{ comment.comment }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-gray-400 mr-2"
                                    v-on:click.prevent="
                                        updateBlog.setUpdateBlogState(
                                            blog.id,
                                            blog.title,
                                            blog.description
                                        )
                                    "
                                >
                                    edit
                                </button>

                                <button
                                    class="bg-gray-400"
                                    v-on:click.prevent="
                                        deleteBlog(blog.id, deleteForm)
                                    "
                                >
                                    delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
