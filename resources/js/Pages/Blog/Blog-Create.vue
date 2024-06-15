<script setup>
import AuthenticatedHeaderLayout from "@/Layouts/AuthenticatedHeaderLayout.vue";
import { useForm } from "@inertiajs/vue3";
const blogForm = useForm({
    title: null,
    description: null,
});
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
                        <div>
                            <div class="flex lg:w-7/12 w-full h-96">
                                <form
                                    class="grid w-full gap-4 mt-4 mx-6"
                                    @submit.prevent="
                                        blogForm.post(route('blog-submit'))
                                    "
                                >
                                    <label for="title">Title:</label>
                                    <input
                                        v-model="blogForm.title"
                                        id="title"
                                        type="text"
                                    />
                                    <label for="description"
                                        >Description:</label
                                    >
                                    <textarea
                                        class="w-full"
                                        v-model="blogForm.description"
                                        id="description"
                                        type="text"
                                    ></textarea>
                                    <button
                                        class="bg-gray-300"
                                        :disabled="blogForm.processing"
                                        type="submit"
                                    >
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
