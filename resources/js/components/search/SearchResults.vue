<template>
    <div class="lg:mt-10 mt-5 mb-2 flex justify-center">
        <div>
            <h1 class="lg:text-xl text-sm font-bold text-gray-900 sm:text-3xl">
                Search results
            </h1>
        </div>
    </div>

    <div v-if="resultQuantity > 0" class="flex lg:mx-20 mx-10 lg:mt-10 mt-4">
        Result: {{ resultQuantity }} products
    </div>
    <span class="flex items-center">
        <span class="h-px flex-1 bg-gray-400 lg:mb-10 mb-5"></span>
    </span>
    <div
        class="grid grid-cols-2 lg:mx-6 lg:grid-cols-5 2xl:grid-cols-5 lg:gap-3"
        v-if="resultQuantity > 0 && products != null"
    >
        <div v-for="product in products" :key="product.id">
            <div class="product-card w-full rounded-lg">
                <div class="group rounded-xl relative block overflow-hidden">
                    <div @click="viewProduct(product.id, product.name)">
                        <img
                            :src="`/images/${product.image}`"
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
                            {{ this.formatCurrency(product.price) }}
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
                                @click="viewProduct(product.id, product.name)"
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
    <div v-else>
        <div class="lg:mt-10 mt-5 mb-2 flex justify-center">
            <div>
                <h1
                    class="lg:text-xl text-sm font-bold text-gray-900 sm:text-3xl"
                >
                    No products were found matching your selection.
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
            <span class="text-gray-800 text-xs lg:text-sm">end </span>
        </div>
    </div>
    <ProductDetailModal
        :show="showModal"
        :product-id="productId"
        @close="closeModal"
    />
    <LoadingSpinner :isLoading="isLoading" />
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import ProductDetailModal from "../ProductDetailModal.vue";
import LoadingSpinner from "../layout/LoadingSpinner.vue";

export default {
    components: {
        ProductDetailModal,
        LoadingSpinner,
    },
    data() {
        return {
            query: "",
            products: [],
            showModal: false,
            productId: null,
            resultQuantity: 0,
            isLoading: true,
            page: 1,
            hasMore: true,
            perPage: 30,
        };
    },
    mounted() {
        this.fetchSearchResults();
        window.addEventListener("scroll", this.handleScroll);
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    watch: {
        "$route.query.query": {
            handler(newQuery) {
                this.query = newQuery;
                this.fetchSearchResults();
            },
            immediate: true,
        },
    },
    methods: {
        viewProduct(id, name) {
            const productName = name.replace(/\s+/g, "-").toLowerCase();
            this.$router.push({
                name: "ViewProduct",
                params: { id: id, productName: productName },
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
        async fetchSearchResults() {
            this.query = this.$route.query.query;
            if (this.query !== "") {
                try {
                    this.isLoading = true;
                    const response = await axios.get(`/api/products/search`, {
                        params: { query: this.query, page: this.page },
                    });
                    // console.log(response.data);
                    if (response.data.success) {
                        if (this.page === 1) {
                            this.products = response.data.products;
                        } else {
                            this.products = [
                                ...this.products,
                                ...response.data.products,
                            ];
                        }
                        this.resultQuantity = response.data.resultQuantity;
                        this.hasMore = response.data.hasMore;
                        this.isLoading = false;
                    }
                } catch (error) {
                    // console.error("Error:", error);
                    this.isLoading = false;
                    this.products = [];
                    this.hasMore = false;
                }
            } else {
                this.isLoading = false;
                this.products = [];
                this.hasMore = false;
            }
        },
        loadMore() {
            if (this.hasMore) {
                this.page += 1;
                this.fetchSearchResults();
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
    },
};
</script>
