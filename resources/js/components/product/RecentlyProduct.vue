<template>
    <div class="mt-5 mb-2 flex justify-center">
        <div>
            <h1 class="lg:text-xl text-sm font-bold text-gray-900 sm:text-3xl">
                Recently products
            </h1>
        </div>
    </div>
    <div
        v-if="displayedProducts != null && displayedProducts.length > 0"
        class="grid grid-cols-1 lg:grid-cols-6 lg:px-2"
    >
        <div class="h-fit moving rounded-lg lg:col-span-6">
            <div
                class="grid grid-cols-2 lg:mx-6 lg:grid-cols-4 2xl:grid-cols-5 lg:gap-1"
            >
                <div v-for="product in displayedProducts" :key="product.id">
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
    <div v-if="displayedProducts != null && displayedProducts.length > 0">
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
import ProductDetailModal from "../ProductDetailModal.vue";

export default {
    name: "RecentlyProduct",
    components: { ProductDetailModal },
    data() {
        return {
            category: "clothes",
            products: [],
            displayedProducts: [],
            page: 1,
            perPage: 36,
            hasMore: true,
            filters: {},
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
                    `/api/product/recently?page=${this.page}`
                );
                // console.log(response.data);
                const newProducts = response.data.data;
                if (newProducts.length < this.perPage) {
                    this.hasMore = false;
                }
                this.products = this.products.concat(newProducts);
                this.applyFilters();
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
        updateFilters(filters) {
            console.log(filters);
            this.filters = filters;
            this.applyFilters();
        },
        applyFilters() {
            let filteredProducts = [...this.products];

            if (this.filters.searchKey) {
                filteredProducts = filteredProducts.filter((product) =>
                    product.name
                        .toLowerCase()
                        .includes(this.filters.searchKey.toLowerCase())
                );
            }

            if (this.filters.priceFrom && this.filters.priceTo) {
                filteredProducts = filteredProducts.filter(
                    (product) =>
                        product.price >= this.filters.priceFrom &&
                        product.price <= this.filters.priceTo
                );
            }

            if (this.filters.filternew == true) {
                filteredProducts = filteredProducts.filter(
                    (product) => product.is_new == 1
                );
            }

            if (this.filters.filterDiscount == true) {
                filteredProducts = filteredProducts.filter(
                    (product) => product.discount > 0
                );
            }

            if (this.filters.instock == true) {
                filteredProducts = filteredProducts.filter(
                    (product) => product.total_quantity > 0
                );
            }

            if (this.filters.outofstock == true) {
                filteredProducts = filteredProducts.filter(
                    (product) => product.total_quantity <= 0
                );
            }

            this.displayedProducts = filteredProducts;
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
