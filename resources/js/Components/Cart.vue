<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    orders: {
        type: Object,
    },
});
const showDropDownState = reactive({
    showdropDownStateValue: false,
    setdropDownStateValue() {
        if (this.showdropDownStateValue) {
            this.showdropDownStateValue = false;
            console.log(this.showdropDownStateValue);
            return;
        }
        console.log(this.showdropDownStateValue);
        this.showdropDownStateValue = true;
    },
});
</script>
<script>
export default {
    methods: {
        deleteOrderItem(orderItemName) {
            router.post(route("remove-item-from-cart"), { orderItemName });
        },
    },
};
</script>
<template>
    <!--     {{ console.log($page.props) }} -->
    <div class="flex items-center">
        <button
            v-on:click="
                () => {
                    showDropDownState.setdropDownStateValue();
                }
            "
            class="border-none"
        >
            Cart
        </button>
        <div
            class="top-12 right-2 absolute w-60 flex flex-col bg-white border px-2 py-4"
            v-if="showDropDownState.showdropDownStateValue"
        >
            <div v-if="$page.props.orders?.length > 0">
                <ul class="flex flex-col gap-1 mb-6">
                    <li
                        class="flex gap-3"
                        v-for="(orderItem, index) in $page.props.orders"
                        :key="index"
                    >
                        <img
                            class="w-2/6 block"
                            :src="`http://127.0.0.1:8000/storage/${orderItem.image}`"
                            alt="product image"
                        />

                        <div class="flex flex-col gap-3">
                            <div>
                                <span>{{ orderItem.name }}</span>
                            </div>
                            <div>
                                <button
                                    class="bg-slate-400"
                                    v-on:click="deleteOrderItem(orderItem.name)"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
                <div>
                    <a class="bg-slate-400" :href="route('orders-view')"
                        >Go to checkout</a
                    >
                </div>
            </div>
            <div class="mt-4 flex justify-center" v-else>
                <span class="text-gray-300">Your cart is empty</span>
            </div>
        </div>
    </div>
    <!--  <div v-else class="flex items-center">
        <button v-on:click="setdropDownStateValue(true)" class="border-none">
            Cart
        </button>
    </div> -->
</template>
