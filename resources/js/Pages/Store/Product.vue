<script setup>
import StoreHeaderLayout from "@/Layouts/StoreHeaderLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { inject } from "@vue/runtime-core";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    product: {
        type: Object,
    },
});
console.log(props, "props");
const userStock = reactive({
    stockStateValue: Math.min(props.product.stock),
    setStockStateValue(stockValue) {
        this.stockStateValue = stockValue;
        console.log(this.stockStateValue);
    },
});
</script>
<script>
export default {
    methods: {
        addToCart(userSelectedStock) {
            const productWithUserStock = Object.assign(
                { userSelectedStock: parseInt(userSelectedStock) },
                this.product
            );
            console.log(productWithUserStock);
            router.post(route("create-order-session"), productWithUserStock);
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
                        <div
                            class="shrink-0 flex items-center gap-3 mb-12 text-gray-400"
                        >
                            <a :href="route('products-view')"
                                >Return to products</a
                            >
                        </div>
                        <div class="flex gap-x-6 mb-6">
                            <div>
                                <a
                                    :href="`Products/${product.name}`"
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
                        <div class="mb-16">
                            <select
                                v-on:change="
                                    (event) => {
                                        userStock.setStockStateValue(
                                            event.currentTarget.value
                                        );
                                    }
                                "
                            >
                                <option
                                    v-for="stockValue in product.stock"
                                    :key="stockValue"
                                    :value="stockValue"
                                >
                                    {{ stockValue }}
                                </option>
                            </select>
                        </div>
                        <div class="flex gap-x-3">
                            <button class="bg-gray-400">Buy</button>
                            <button
                                v-on:click="
                                    addToCart(userStock.stockStateValue)
                                "
                                class="bg-gray-400"
                            >
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
