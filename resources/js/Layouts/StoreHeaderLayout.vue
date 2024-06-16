<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import Cart from "@/Components/Cart.vue";
</script>

<template>
    <div>
        <div>
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="shrink-0 flex items-center gap-3">
                            <Link href="/">Home</Link>
                            <Link :href="route('products-view')">Products</Link>
                        </div>
                        <Cart></Cart>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>
