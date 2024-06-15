<script setup>
import MovieHeaderLayout from "@/Layouts/movieHeaderLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { inject } from "@vue/runtime-core";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    movies: {
        type: Array,
    },
});
</script>
<template>
    {{ console.log($page.props) }}
    <div class="min-h-screen bg-gray-100">
        <MovieHeaderLayout></MovieHeaderLayout>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <h1>Movies</h1>
                        <div>
                            <ul class="flex flex-wrap gap-y-12">
                                <li
                                    class="w-1/2"
                                    v-for="(movie, index) in ($page,
                                    props.movies)"
                                    :key="index"
                                >
                                    <div class="flex gap-12">
                                        <div class="w-1/2">
                                            <img
                                                :src="`${movie.image}`"
                                                alt=""
                                                srcset=""
                                            />
                                        </div>
                                        <div
                                            class="flex flex-col gap-3 max-w-fit"
                                        >
                                            <span>Title:{{ movie.title }}</span>
                                            <span
                                                >Director:{{
                                                    movie.director
                                                }}</span
                                            >
                                            <span
                                                >Languages:{{
                                                    movie.languages
                                                }}</span
                                            >
                                            <span
                                                >Length:{{
                                                    movie.film_length
                                                }}hrs</span
                                            >
                                            <p class="text-balance w-1/2">
                                                {{ movie.description }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
