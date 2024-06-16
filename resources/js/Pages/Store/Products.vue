<script setup>
import StoreHeaderLayout from "@/Layouts/StoreHeaderLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { inject } from "@vue/runtime-core";
import { router } from "@inertiajs/vue3";
defineProps({
    products: {
        type: Object,
    },
});
</script>
<script>
export default {
    methods: {
        createOrderSession(product) {
            product.userSelectedStock = 1;

            router.post(route("create-order-session"), product);
        },
    },
};
</script>
<template>
    <div class="min-h-screen bg-gray-100">
        <StoreHeaderLayout></StoreHeaderLayout>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <h1 class="mb-20 text-4xl">Products</h1>
                        <ul class="flex flex-col gap-y-3">
                            <li
                                v-for="(product, index) in products"
                                :key="index"
                                class="mb-20"
                            >
                                <div class="flex gap-x-6 mb-6">
                                    <div>
                                        <a
                                            :href="`/Products/Product/${product.name}`"
                                            class="border-none"
                                        >
                                            <img
                                                class="w-36"
                                                :src="`http://127.0.0.1:8000/storage/${product.image}`"
                                                alt="product image"
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl">
                                            {{ product.name }}
                                        </h2>
                                        <span
                                            ><b class="text-2xl"
                                                >{{ product.price }}$</b
                                            ></span
                                        >
                                    </div>
                                </div>

                                <div class="mb-16">
                                    <div>
                                        <p class="text-balance">
                                            {{ product.description }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-x-3">
                                    <a
                                        v-on:click="createOrderSession(product)"
                                        :href="route('orders-view')"
                                        class="bg-gray-400"
                                    >
                                        Buy
                                    </a>
                                    <button
                                        v-on:click="createOrderSession(product)"
                                        class="bg-gray-400"
                                    >
                                        Add to cart
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
