<template>
    <div class="my-5 mb-3 mt-2 mx-3 flex justify-center">
        <div>
            <h1 class="text-xl font-bold mt-7 text-gray-900 sm:text-3xl">
                Related product
            </h1>
        </div>
    </div>
    <span class="flex items-center">
        <span class="h-px flex-1 bg-gray-300"></span>
    </span>
    <div
        v-if="products != null && products.length > 0"
        class="h-fit moving rounded-lg lg:mt-8 mt-2 lg:col-span-5"
    >
        <div
            class="grid grid-cols-2 lg:mx-6 lg:grid-cols-5 2xl:grid-cols-5 gap-1 lg:gap-4"
        >
            <div v-for="product in products" :key="product.id">
                <div class="product-card w-full rounded-lg">
                    <div
                        class="group rounded-xl relative block overflow-hidden"
                    >
                        <div @click="viewProduct(product.id)">
                            <img
                                :src="`/images/${product.image1}`"
                                :alt="product.name"
                                class="primage rounded-t-2xl w-full object-cover transition duration-500 group-hover:scale-105"
                            />
                        </div>
                        <div class="relative p-6">
                            <div class="flex items-baseline lg:items-start">
                                <h3
                                    class="mr-3 flex text-[11px] lg:text-sm font-medium"
                                >
                                    {{ product.name }}
                                </h3>
                                <span
                                    v-if="product.is_new"
                                    class="rounded-full mr-1 text-white bg-red-600 px-1 lg:px-1.5 lg:py-0.5 text-xs font-medium"
                                >
                                    New
                                </span>
                                <span
                                    v-if="product.discount > 0"
                                    class="rounded-full text-white bg-red-600 px-1 lg:px-1.5 lg:py-0.5 text-xs font-medium"
                                >
                                    - {{ product.discount }} %
                                </span>
                            </div>
                            <p
                                class="mt-1.5 text-[11px] lg:text-sm text-gray-600 transition hover:text-gray-800"
                            >
                                {{ formatCurrency(product.price) }}
                            </p>
                            <div class="flex justify-center mt-1">
                                <div
                                    @click="openModal(product.id)"
                                    class="text-xs my-2 hover:cursor-pointer"
                                >
                                    <button
                                        class="inline-block hover:border-red-500 mr-2 rounded-xl border border-gray-400 text-gray-700 lg:px-3 px-2 py-1 text-sm font-medium transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring"
                                    >
                                        Detail
                                    </button>
                                </div>
                                <div
                                    class="text-xs my-2 hover:cursor-pointer"
                                    @click="viewProduct(product.id)"
                                >
                                    <p
                                        class="inline-block rounded-xl hover:border-red-500 border border-gray-400 text-gray-700 lg:px-3.5 px-2.5 py-1 text-sm font-medium transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring"
                                    >
                                        View
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="flex mt-20 justify-center items-center h-full w-full">
            <div>
                <h1
                    class="lg:text-xl text-sm font-bold text-gray-900 sm:text-3xl"
                >
                    No product!
                </h1>
            </div>
        </div>
    </div>
    <div v-if="products != null && products.length > 0">
        <div
            v-if="hasMore"
            class="flex mt-2 w-full items-center justify-center"
        >
            <button @click="loadMore" class="text-gray-800 text-xs lg:text-sm">
                Loading...
            </button>
        </div>
        <div v-else class="flex mt-2 w-full items-center justify-center">
            <span class="text-gray-800 text-xs lg:text-sm"> End </span>
        </div>
    </div>
    <ProductDetailModal
        :show="showModal"
        :product-id="productId"
        @close="closeModal"
    />
</template>
<script>
import axios from "axios";
import { mapActions, mapState } from "vuex";
import ProductDetailModal from "../ProductDetailModal.vue";

export default {
    name: "RelatedProduct",
    emits: ["viewProduct"],
    components: {
        ProductDetailModal,
    },
    data() {
        return {
            products: [],
            page: 1,
            perPage: 36,
            hasMore: true,
            showModal: false,
            productId: null,
        };
    },
    mounted() {
        this.fetchData();
        window.addEventListener("scroll", this.handleScroll);
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        viewProduct(productId) {
            this.$router.push({
                name: "ViewProduct",
                params: { id: productId },
            });
        },
        closeModal() {
            this.showModal = false;
            this.productId = null;
        },
        openModal(productId) {
            this.productId = productId;
            this.showModal = true;
        },

        async fetchData() {
            try {
                const response = await axios.get(
                    `/api/products/related?page=${this.page}`
                );
                const newProducts = response.data.productsMore;
                if (response.data.hasMore == false) {
                    this.hasMore = false;
                }
                this.products = this.products.concat(newProducts);
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },

        loadMore() {
            if (this.hasMore) {
                this.page += 1;
                this.fetchData();
            }
        },
        handleScroll() {
            const bottomOfWindow =
                window.innerHeight + window.scrollY >=
                document.documentElement.offsetHeight - 40;
            if (bottomOfWindow && this.hasMore) {
                this.loadMore();
            }
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
