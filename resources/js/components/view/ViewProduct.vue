<template>
    <LoadingSpinner :isLoading="isLoading" />
    <div class="modal-addcart">
        <div class="modal-content-addcart">
            <p class="text-black text-center text-sm">
                Added to cart successfully.
            </p>
            <ul class="py-1 px-2 flex items-center justify-center">
                <li class="flex items-center gap-2">
                    <img
                        :src="`/images/${notification.image}`"
                        :alt="notification.image"
                        class="size-28 rounded object-cover"
                    />
                    <div>
                        <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
                            <div>
                                <dd class="inline">
                                    {{ notification.name }} x
                                    {{ notification.quantity }}
                                </dd>
                            </div>
                            <div>
                                <dt class="inline mr-1">Size:</dt>
                                <dd class="inline">{{ notification.size }}</dd>
                            </div>

                            <div>
                                <dt class="inline mr-1">Color:</dt>
                                <dd class="inline">{{ notification.color }}</dd>
                            </div>
                        </dl>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="text-center">
        <h1 class="text-xl font-bold mt-6 lg:mt-8 text-gray-900 sm:text-3xl">
            Product View
        </h1>
    </div>
    <div class="grid mt-3 grid-cols-1 lg:grid-cols-4">
        <div class="standing-viewcart ml-1 px-5 content-center">
            <div v-if="ProductDetails">
                <div class="flex justify-start lg:px-8 pt-3">
                    <strong class="text-gray-900 text-sm italic"
                        >Product Details</strong
                    >
                </div>
                <div class="lg:px-8 mb-5">
                    <ul class="my-3 ml-3 lg:mt-6 lg:ml-5">
                        <li v-for="detail in ProductDetails" class="text-xs">
                            - {{ detail.description }}
                        </li>
                    </ul>
                    <div class="text-[12px]">Name: {{ product.name }}</div>
                    <div
                        v-if="colors && colors.length > 0"
                        class="mt-9 inline text-[12px]"
                    >
                        Color:
                        <span
                            v-for="(color, index) in colors"
                            :key="color.id"
                            class="inline"
                        >
                            {{ color.color }}
                            <span v-if="index < colors.length - 1">,</span>
                        </span>
                    </div>
                    <div v-if="ProductDetail.category_name" class="text-[12px]">
                        For: {{ ProductDetail.category_name }}
                    </div>
                    <div
                        v-if="soldQuantity != null && soldQuantity > 0"
                        class="text-[12px]"
                    >
                        {{ soldQuantity }} products sold
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="productdetail">
                <div class="pcViewCart">
                    <div
                        v-for="ProductDetailImg in ProductDetailImg"
                        :key="ProductDetailImg.id"
                        class="mb-2"
                        data-aos="zoom-out-up"
                    >
                        <img
                            class="image-detail"
                            :src="'/images/' + ProductDetailImg.image"
                            :alt="ProductDetailImg.image"
                        />
                    </div>
                </div>
                <!--  pc and mobile -->
                <div class="swiper mySwiper mobileViewCart">
                    <div class="swiper-wrapper">
                        <div
                            v-for="ProductDetailImg in ProductDetailImg"
                            :key="ProductDetailImg.id"
                            class="swiper-slide"
                        >
                            <img
                                class="image-detail"
                                :src="'/images/' + ProductDetailImg.image"
                                :alt="ProductDetailImg.image"
                            />
                        </div>
                    </div>
                    <div class="button-next swiper-button-next"></div>
                    <div class="button-prev swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <div class="standing-viewcart px-5 lg:mb-10 lg:px-0 content-center">
            <div class="relative ml-2 mt-1 lg:mt-8">
                <div class="flex">
                    <div v-if="product.is_new === 1">
                        <span
                            class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"
                        >
                            New
                        </span>
                    </div>
                    <div v-if="product.remaining > 0 && product.discount > 0">
                        <span
                            class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"
                        >
                            - {{ product.discount }}%
                        </span>
                    </div>
                    <div v-if="product.total_quantity <= 0">
                        <span
                            class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"
                        >
                            Sold out
                        </span>
                    </div>
                </div>
                <h3 class="text-[16px] text-gray-700 mt-3">
                    {{ product.name }}
                </h3>
                <p class="text-[12px] text-gray-700">
                    {{ this.formatCurrency(product.price) }}
                </p>
                <p
                    class="text-sm text-gray-700 mt-2 hover:text-blue-700 hover:underline"
                >
                    <button class="text-xs underline" @click="openModalSize()">
                        SIZE CHART
                    </button>
                </p>
                <form @submit.prevent="addToCart">
                    <div class="flex">
                        <div class="w-full">
                            <select
                                name="size"
                                id="size"
                                v-model="size"
                                class="text-[12px] border-gray-400 rounded border w-2/6 mt-1 p-1 text-gray-700 hover:text-blue-700 placeholder-gray-400"
                            >
                                <option value="" disabled>Select Size</option>
                                <option
                                    v-for="sizeItem in sizes"
                                    :key="sizeItem.id"
                                    :value="sizeItem.size"
                                >
                                    {{ sizeItem.size }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <select
                            for="color"
                            name="color"
                            id="color"
                            v-model="color"
                            class="text-[12px] border-gray-400 rounded border w-2/6 mt-1 p-1 text-gray-700 hover:text-blue-700"
                        >
                            <option value="" disabled selected>
                                Select Color
                            </option>
                            <option
                                v-for="colorItem in colors"
                                :key="colorItem.id"
                                :value="colorItem.color"
                            >
                                {{ colorItem.color }}
                            </option>
                        </select>
                        <div class="flex py-2 items-center">
                            <button
                                @click="decreaseQuantity()"
                                type="button"
                                class="mr-1 text-gray-600 transition hover:opacity-75"
                            >
                                &minus;
                            </button>
                            <input
                                type="number"
                                id="Quantity"
                                v-model="quantity"
                                class="h-6 w-10 border rounded border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                            />
                            <button
                                @click="increaseQuantity()"
                                type="button"
                                class="ml-1 text-gray-600 transition hover:opacity-75"
                            >
                                &plus;
                            </button>
                        </div>
                        <div class="text-gray-700 mt-1 text-[12px]">
                            {{
                                stockQuantity !== null &&
                                stockQuantity !== undefined
                                    ? stockQuantity +
                                      " item" +
                                      (stockQuantity === 1 ? "" : "s") +
                                      " in stock"
                                    : product.total_quantity +
                                      " item" +
                                      (product.total_quantity === 1
                                          ? ""
                                          : "s") +
                                      " in stock"
                            }}
                        </div>
                    </div>
                    <div
                        v-if="errorMessages.length"
                        class="error-messages mt-2 text-xs text-red-600"
                    >
                        <ul>
                            <li
                                class="mt-1"
                                v-for="(error, index) in errorMessages"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="flex lg:justify-start justify-center mt-3">
                        <div class="mr-2">
                            <div
                                class="group hover:border-red-500 relative inline-flex items-center overflow-hidden rounded-full border px-6 py-2 text-gray-600 focus:outline-none focus:ring active:text-gray-700"
                            >
                                <span
                                    class="absolute -end-full transition-all group-hover:end-4"
                                >
                                    <svg
                                        class="size-4 rtl:rotate-180"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                                        />
                                    </svg>
                                </span>

                                <div>
                                    <button
                                        class="text-sm font-medium transition-all group-hover:me-4"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div
                                class="group hover:border-red-500 relative inline-flex items-center overflow-hidden rounded-full border px-8 py-2 text-gray-600 focus:outline-none focus:ring active:text-gray-700"
                            >
                                <span
                                    class="absolute -end-full transition-all group-hover:end-4"
                                >
                                    <svg
                                        class="size-4 rtl:rotate-180"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                                        />
                                    </svg>
                                </span>
                                <div>
                                    <button
                                        @click="buyNow()"
                                        class="text-sm font-medium transition-all group-hover:me-4"
                                        type="button"
                                    >
                                        Buy now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-if="product.description != null" class="lg:px-4 px-3">
        <div class="text-center mt-10 lg:mt-0">
            <h1 class="text-xl font-bold mt-4 text-gray-900 sm:text-3xl">
                Detail product
            </h1>
        </div>
        <span class="flex pt-2 pb-5 items-center">
            <span class="h-px flex-1 bg-slate-300"></span>
        </span>
        <div v-html="product.description"></div>
    </div>

    <RelatedProduct />
    <sizeChart
        :showModalSize="showModalSizeChart"
        @closeModalSize="closeModalSize"
        :categoryProp="cateName"
    />
</template>

<script>
import RelatedProduct from "@/components/product/RelatedProduct.vue";
import { ref, onMounted, watch } from "vue";
import { mapGetters, mapMutations, mapActions, mapState } from "vuex";
import { useRoute } from "vue-router";
import axios from "axios";
import LoadingSpinner from "../layout/LoadingSpinner.vue";
import sizeChart from "../modal/SizeChart.vue";
export default {
    props: ["id"],
    components: {
        RelatedProduct,
        LoadingSpinner,
        sizeChart,
    },
    data() {
        return {
            selectedProduct: null,
            showModal: false,
            errorMessages: [],
            product: [],
            productVariant: [],
            productInfor: [],
            ProductDetailImg: [],
            ProductDetail: [],
            ProductDetails: [],
            sizes: [],
            colors: [],
            quantity: 1,
            soldQuantity: null,
            stockQuantity: null,
            product_id: null,
            discount_id: null,
            discountPercent: null,
            size: null,
            color: null,
            notification: {
                image: null,
                color: null,
                size: null,
                quantity: null,
                name: null,
            },
            isLoading: true,
            showModalSizeChart: false,
            cateName: null,
        };
    },

    mounted() {
        this.getProductDetail(this.id);
    },
    watch: {
        id(newId) {
            this.getProductDetail(newId);
            this.checkStock();
        },
        size() {
            this.checkStock();
        },
        color() {
            this.checkStock();
        },
        product_id(newId) {
            this.checkStock();
            this.quantity = 1;
        },
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    methods: {
        openModalSize() {
            this.showModalSizeChart = true;
        },
        closeModalSize() {
            this.showModalSizeChart = false;
        },
        ...mapActions(["fetchCartQuantity"]),
        showProductDetail(product) {
            this.selectedProduct = product;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        showNotification(quantity, color, size, image, name) {
            var modal = document.querySelector(".modal-addcart");
            modal.style.display = "block";
            this.notification.image = image;
            this.notification.color = color;
            this.notification.size = size;
            this.notification.quantity = quantity;
            this.notification.name = name;
            setTimeout(() => {
                modal.style.display = "none";
            }, 3000);
        },
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        increaseQuantity() {
            this.quantity++;
        },
        buyNow() {
            this.addToCart(true);
        },
        addToCart(redirectToCheckout = false) {
            this.errorMessages = [];
            axios
                .post("/api/add-cart", {
                    product_id: this.product_id,
                    discount_id: this.discount_id,
                    discountPercent: this.discountPercent,
                    size: this.size,
                    color: this.color,
                    quantity: this.quantity,
                })
                .then((response) => {
                    // console.log(response.data);
                    if (response.data.success == true) {
                        if (redirectToCheckout == true) {
                            this.$router.push({ name: "Checkout" });
                        }
                        const quantity = response.data.dataProduct.quantity;
                        const color = response.data.dataProduct.color;
                        const size = response.data.dataProduct.size;
                        const image = response.data.dataProduct.imageURL;
                        const name = response.data.dataProduct.name;
                        this.showNotification(
                            quantity,
                            color,
                            size,
                            image,
                            name
                        );
                        this.fetchCartQuantity();
                    } else if (response.data.success == false) {
                        this.errorMessages = response.data.error;
                    }
                })
                .catch((error) => {
                    this.errorMessages = [error];
                });
        },
        async checkStock() {
            this.errorMessages = [];
            try {
                if (!this.color || !this.size || !this.product_id) {
                    this.stockQuantity = null;
                    return;
                }
                const response = await axios.post("/api/check-stock", {
                    product_id: this.product_id,
                    size: this.size,
                    color: this.color,
                });
                if (response.data.success == true) {
                    this.stockQuantity = response.data.productVariant.quantity;
                }
                if (response.data.success == false) {
                    this.stockQuantity = 0;
                }
            } catch (error) {
                console.error("Error checking stock:", error);
            }
        },

        getProductDetail(id) {
            axios
                .get(`/api/product/view/${id}`)
                .then((response) => {
                    this.product = response.data.product;
                    this.cateName = response.data.product.class;
                   
                    this.ProductDetailImg = response.data.ProductDetailImg;
                    this.sizes = response.data.sizes;
                    this.colors = response.data.colors;
                    this.product_id = this.product.id;
                    this.discount_id = this.product.discount_id;
                    this.discountPercent = this.product.discount;
                    this.size = null;
                    this.color = null;
                    this.ProductDetail = response.data.product_info;
                    this.ProductDetails = response.data.productDetails;
                    this.soldQuantity = this.product.sales_count;
                    this.addToRecentlyViewed(response.data.product.id);
                    this.checkStock();
                    this.initializeSwiper();
                    this.isLoading = false;

                    // window.scrollTo({ top: 0, behavior: "smooth" });
                })
                .catch((error) => {
                    this.isLoading = false;

                    console.log(error);
                });
        },
        async addToRecentlyViewed(productId) {
            let formData = new FormData();
            formData.append("productId", productId);
            axios
                .post("/api/addToRecently", formData)
                .then((response) => {
                    //   console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        initializeSwiper() {
            if (this.swiper) {
                this.swiper.destroy(true, true);
            }
            this.swiper = new Swiper(".mySwiper", {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                },
                cssMode: true,
                keyboard: true,
            });
        },
    },
};
</script>
