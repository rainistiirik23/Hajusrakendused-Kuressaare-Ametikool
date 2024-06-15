<script setup>
import StoreHeaderLayout from "@/Layouts/StoreHeaderLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { inject } from "@vue/runtime-core";
import { reactive, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    orders: {
        type: Object,
    },
});
const paymentInfoForm = useForm({
    firstName: null,
    lastName: null,
    email: null,
    phone: null,
});

const showCheckoutState = reactive({
    showCheckoutStateValue: false,
    setShowCheckoutStateValue() {
        if (this.showCheckoutStateValue) {
            this.showCheckoutStateValue = false;
            return;
        }
        this.showCheckoutStateValue = true;
    },
});
</script>
<script>
export default {
    methods: {
        changeOrderItemUserSelectedStock(userSelectedStock, index) {
            router.post(route("change-order-user-selected-stock"), {
                userSelectedStockValue: userSelectedStock,
                orderIndex: index,
            });
        },

        deleteOrderItem(orderItemName) {
            router.post(route("remove-item-from-cart"), { orderItemName });
        },
        sendOrderWithPaymentInfo(orderProp, paymentInfoForm) {
            router.post(route("order-payment"), {
                orderItems: orderProp,
                paymentInfo: paymentInfoForm,
            });
        },
    },
};
</script>
<template>
    <div class="min-h-screen bg-gray-100">
        <StoreHeaderLayout></StoreHeaderLayout>
        <main>
            <div class="max-h-fit">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <h1 class="mb-20 text-4xl">Your items</h1>
                        <ul class="flex flex-col gap-y-3">
                            <li
                                v-for="(order, index) in orders"
                                :key="index"
                                class="mb-20"
                            >
                                <div class="flex gap-x-6 mb-6">
                                    <div>
                                        <a
                                            :href="`/Products/Product/${order.name}`"
                                            class="border-none"
                                        >
                                            <img
                                                class="w-36"
                                                :src="`http://127.0.0.1:8000/storage/${order.image}`"
                                                alt="order image"
                                            />
                                        </a>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl">
                                            {{ order.name }}
                                        </h2>
                                        <span
                                            ><b class="text-2xl"
                                                >{{ order.price }}$</b
                                            ></span
                                        >
                                        <div class="mb-16">
                                            <select
                                                v-on:change="
                                                    (event) => {
                                                        changeOrderItemUserSelectedStock(
                                                            event.currentTarget
                                                                .value,
                                                            index
                                                        );
                                                    }
                                                "
                                            >
                                                <option
                                                    hidden
                                                    selected="selected"
                                                >
                                                    {{
                                                        order.userSelectedStock
                                                    }}
                                                </option>
                                                <option
                                                    v-for="orderStockValue in order.stock"
                                                    :key="orderStockValue"
                                                    :value="orderStockValue"
                                                >
                                                    {{ orderStockValue }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="bg-slate-400"
                                    v-on:click="deleteOrderItem(order.name)"
                                >
                                    Delete
                                </button>

                                <div class="flex gap-x-3"></div>
                            </li>
                        </ul>
                        <div>
                            <button
                                class="bg-slate-400"
                                v-on:click="
                                    () => {
                                        showCheckoutState.setShowCheckoutStateValue();
                                    }
                                "
                            >
                                {{
                                    showCheckoutState.showCheckoutStateValue
                                        ? "Cancel"
                                        : "Proceed To checkout"
                                }}
                            </button>
                        </div>

                        <div
                            v-if="showCheckoutState.showCheckoutStateValue"
                            class="flex lg:w-7/12 w-full h-fit mb-5"
                        >
                            <form
                                class="grid w-full gap-4 mt-4 mx-6"
                                @submit.prevent="
                                    sendOrderWithPaymentInfo(
                                        $page.props.orders,
                                        paymentInfoForm
                                    );
                                    showCheckoutState.setShowCheckoutStateValue();
                                "
                            >
                                <label for="Firstname">Firstname:</label>
                                <input
                                    required
                                    v-model="paymentInfoForm.firstName"
                                    id="Firstname"
                                    type="text"
                                />
                                <label for="LastName">Lastname:</label>
                                <input
                                    required
                                    class="w-full"
                                    v-model="paymentInfoForm.lastName"
                                    id="LastName"
                                    type="text"
                                />
                                <label for="email">email:</label>
                                <input
                                    required
                                    class="w-full"
                                    v-model="paymentInfoForm.email"
                                    id="LastName"
                                    type="text"
                                />
                                <label for="phone">phone:</label>
                                <input
                                    required
                                    class="w-full"
                                    v-model="paymentInfoForm.phone"
                                    id="LastName"
                                    type="tel"
                                />
                                <div class="flex justify-center">
                                    <button
                                        class="bg-gray-300 w-fit"
                                        :disabled="paymentInfoForm.processing"
                                        type="submit"
                                    >
                                        Confirm payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
