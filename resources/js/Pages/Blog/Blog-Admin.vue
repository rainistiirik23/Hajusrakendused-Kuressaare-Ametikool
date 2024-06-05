<script setup>
import AuthenticatedHeaderLayout from "../../Layouts/AuthenticatedHeaderLayout.vue";
import GuestLayout from "../../Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import { inject } from "@vue/runtime-core";
const route = inject("route");
defineProps({
    blogs: {
        type: Object,
    },
});
</script>
<script>
export default {
    methods: {
        deleteComment(commentId) {
            useForm({
                commentId: commentId,
            }).delete(route("blog-comment-delete"));
        },
    },
};
</script>
<template>
    <div class="min-h-screen bg-gray-100">
        <AuthenticatedHeaderLayout
            v-if="$page.props.auth.user"
        ></AuthenticatedHeaderLayout>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <ul>
                            <h2 class="text-4xl">Blogs</h2>
                            <li
                                v-for="(blog, index) in blogs.data"
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
                                <div class="my-6">{{ blog.description }}</div>
                                <div>
                                    <h3 class="text-4xl font-bold mb-6">
                                        Comments
                                    </h3>
                                    <div class="mb-6">
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
                                                <button
                                                    class="ml-4 bg-gray-400"
                                                    v-on:click.prevent="
                                                        deleteComment(
                                                            comment.id
                                                        )
                                                    "
                                                >
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="flex flex-col gap-y-2">
                                        <form
                                            @submit.prevent="
                                                console.log(commentForm)
                                            "
                                        >
                                            <input
                                                placeholder="comment here"
                                                @input="
                                                    (event) => {
                                                        commentForm.setcommentFormsState(
                                                            blog.id,
                                                            event.currentTarget
                                                                .value
                                                        );
                                                    }
                                                "
                                                class="w-max"
                                                type="text"
                                            />
                                            <form
                                                @submit.prevent="
                                                    commentForm.commentFormState.post(
                                                        route('comment-submit')
                                                    )
                                                "
                                            >
                                                <button
                                                    class="bg-gray-400 w-max"
                                                    type="submit"
                                                >
                                                    Submit
                                                </button>
                                            </form>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
