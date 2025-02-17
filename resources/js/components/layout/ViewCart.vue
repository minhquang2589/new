<template>
    <div @mouseleave="closeCart" class="viewCart">
        <div class="bg-white">
            <div
                class="flex justify-end bg-white text-gray-900 mx-4 mt-4 transition"
            >
                <button @click="closeViewCart" class="togger-hidden-viewcart">
                    &times;
                </button>
            </div>
            <div class="text-center">
                <h1 class="text-xl font-bold text-gray-900">Your Cart</h1>
            </div>
            <span class="flex mt-1 items-center">
                <span class="h-px flex-1 bg-gray-400"></span>
            </span>
            <div class="px-4 sm:px-6 lg:px-6">
                <div class="mt-4 space-y-6">
                    <ul class="space-y-2">
                        <template v-for="(item, index) in cart">
                            <li class="flex items-center gap-4">
                                <img
                                    @click="viewProduct(item.id, item.name)"
                                    :src="'/images/' + item.image"
                                    alt=""
                                    class="size-20 rounded hover:cursor-pointer object-cover"
                                />

                                <div>
                                    <h3
                                        @click="viewProduct(item.id, item.name)"
                                        class="text-sm text-gray-900 hover:text-blue-600 hover:cursor-pointer"
                                    >
                                        {{ item.name }} x {{ item.quantity }}
                                    </h3>

                                    <dl
                                        class="mt-0.5 space-y-px text-[10px] text-gray-600"
                                    >
                                        <div>
                                            <dt class="inline mr-1">Size:</dt>
                                            <dd class="inline">
                                                {{ item.size }}
                                            </dd>
                                        </div>

                                        <div>
                                            <dt class="inline mr-1">Color:</dt>
                                            <dd class="inline">
                                                {{ item.color }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                                <div
                                    class="flex flex-1 items-center justify-end gap-2"
                                >
                                    <LoadingButton
                                        :loading="
                                            isLoadingButton(
                                                item.id,
                                                item.size,
                                                item.color,
                                                item.quantity
                                            )
                                        "
                                        @click="
                                            removeItem(
                                                item.id,
                                                item.size,
                                                item.color,
                                                item.quantity
                                            )
                                        "
                                    >
                                        <span
                                            class="text-gray-600 transition hover:text-red-600"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-4 w-4"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                                />
                                            </svg>
                                        </span>
                                    </LoadingButton>
                                </div>
                            </li>
                            <span
                                v-if="index !== cart.length - 1"
                                class="flex py-1.5 items-center"
                            >
                                <span class="h-px flex-1 bg-gray-400"></span>
                            </span>
                        </template>
                    </ul>

                    <div v-if="dataCartView != null" class="text-center">
                        <div
                            class="flex justify-start text-sm text-gray-800 mt-5"
                        >
                            <div>
                                Total: {{ formatCurrency(cartData.subtotal) }}
                            </div>
                        </div>
                        <span class="flex items-center mb-5">
                            <span class="h-px flex-1 bg-gray-500"></span>
                        </span>
                        <router-link to="/cart">
                            <a
                                href="#"
                                class="block rounded border border-gray-600 px-5 py-3 text-sm text-gray-600 transition hover:ring-1 hover:ring-gray-400"
                            >
                                View my cart
                            </a>
                        </router-link>
                        <router-link to="/checkout">
                            <a
                                href="#"
                                class="block rounded bg-gray-900 mt-2 mb-5 px-5 py-3 text-sm text-gray-100 transition hover:bg-black"
                            >
                                Checkout
                            </a>
                        </router-link>
                    </div>
                    <div v-if="dataCartView == null" class="text-center">
                        <h1 class="text-xl italic text-gray-600">
                            No item in cart!
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import axios from "axios";
import LoadingButton from "./LoadingButton.vue";

export default {
    name: "ViewCart",
    components: { LoadingButton },
    props: {
        toggleViewCart: {
            type: Function,
            required: true,
        },
    },
    data() {
        return {
            dataCartView: [],
            subTotal: null,
            isCartOpen: false,
            loadingButtons: {},
        };
    },
    computed: {
        ...mapGetters(["cart", "cartData"]),
    },
    methods: {
        ...mapActions(["fetchCart", "fetchCartData", "fetchCartQuantity"]),
        closeViewCart() {
            this.toggleViewCart();
        },
        closeCart() {
            this.toggleViewCart();
        },
        viewProduct(id, name) {
            const productName = name.replace(/\s+/g, "-").toLowerCase();
            this.$router.push({
                name: "ViewProduct",
                params: { id: id, productName: productName },
            });
        },
        isLoadingButton(id, size, color, quantity) {
            return (
                this.loadingButtons[`${id}_${size}_${color}_${quantity}`] ||
                false
            );
        },
        removeItem(id, size, color, quantity) {
            this.loadingButtons[`${id}_${size}_${color}_${quantity}`] = true;
            axios
                .delete(`/api/cart/remove/${id}/${size}/${color}/${quantity}`)
                .then((response) => {
                    if (response.data.success === true) {
                        this.fetchCart();
                        this.fetchCartData();
                        this.fetchCartQuantity();
                        this.loadingButtons[
                            `${id}_${size}_${color}_${quantity}`
                        ] = false;
                    }
                })
                .catch((error) => {
                    this.loadingButtons[
                        `${id}_${size}_${color}_${quantity}`
                    ] = false;
                    console.error("Error removing item:", error);
                });
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
    },
};
</script>
<style>
.viewCart {
    z-index: 9999 !important;
}
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 8888 !important;
    transition: opacity 0.5s ease;
    opacity: 1;
}
.view-cart {
    position: fixed;
    top: 0;
    right: -370px;
    bottom: 0;
    width: 370px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    z-index: 9999 !important;
    transition: right 0.5s ease;
}
.togger-hidden-viewcart {
    font-size: 32px;
    cursor: pointer;
    z-index: 9999 !important;
    cursor: pointer;
    color: black;
    margin-right: 10px;
}

.view-cart-open {
    right: 0;
}

@media screen and (max-width: 1000px) {
    .view-cart {
        width: 330px;
    }
}

@media only screen and (max-width: 768px) {
    .view-cart {
        width: 300px;
    }
    .togger-hidden-viewcart {
        font-size: 28px;
        margin-right: 0px;
    }
}
</style>
