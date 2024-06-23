<template>
    <div
        class="modal-detail-overlay"
        v-if="show"
        data-aos="fade-in"
        @click.self="closeModal"
    >
        <div class="modal-detail-content pt-2" @click.stop>
            <div class="grid grid-cols-1 lg:grid-cols-5">
                <div
                    class="standing-viewcart ml-1 px-5 content-center lg:col-span-2"
                >
                    <div class="close-detail-button" @click="closeModal">
                        &times;
                    </div>
                    <div
                        class="relative mt-1 lg:mt-8"
                        data-aos="fade-down-right"
                    >
                        <div class="flex">
                            <div v-if="product.is_new === 1">
                                <span
                                    class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"
                                >
                                    New
                                </span>
                            </div>
                            <div
                                v-if="
                                    product.remaining > 0 &&
                                    product.discount > 0
                                "
                            >
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
                        <div class="flex justify-start my-4 text-[12px]">
                            <ul>
                                <li>
                                    <div v-if="colors && colors.length > 0">
                                        Color:
                                        <span
                                            v-for="(color, index) in colors"
                                            :key="color.id"
                                        >
                                            {{ color.color }}
                                            <span
                                                v-if="index < colors.length - 1"
                                                >,</span
                                            >
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Sizes:
                                        <span
                                            v-for="(value, index) in sizes"
                                            :key="value.id"
                                        >
                                            {{ value.size }}
                                            <span
                                                v-if="index < sizes.length - 1"
                                                >,</span
                                            >
                                        </span>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div v-if="ProductDetail.category_name">
                                        For: {{ ProductDetail.category_name }}
                                    </div>
                                    <div
                                        v-if="
                                            soldQuantity != null &&
                                            soldQuantity > 0
                                        "
                                    >
                                        {{ soldQuantity }} products sold
                                    </div>
                                </li>
                                <li
                                    v-if="
                                        ProductDetails &&
                                        ProductDetails.length > 0
                                    "
                                    v-for="detail in ProductDetails"
                                    class="text-xs"
                                >
                                    - {{ detail.description }}
                                </li>
                                <li
                                    class="text-xs flex justify-center mt-5 mb-2 lg:my-8 hover:cursor-pointer"
                                    @click="viewProduct(product.id)"
                                >
                                    <p
                                        class="inline-block rounded-xl border-gray-500 text-gray-700 hover:border-red-500 border border-current px-3 py-1 lg:px-5 lg:py-1.5 text-sm font-medium transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring"
                                    >
                                        View Product
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <div class="productdetail">
                        <div class="pcViewCart">
                            <div
                                @click="viewProduct(product.id)"
                                v-for="ProductDetailImg in ProductDetailImg"
                                :key="ProductDetailImg.id"
                                class="mb-2"
                                data-aos="fade-left"
                            >
                                <img
                                    class="image-detail"
                                    :src="'/images/' + ProductDetailImg.image"
                                    :alt="ProductDetailImg.image"
                                />
                            </div>
                        </div>
                        <!-- Swiper for Mobile View -->
                        <div class="swiper mySwiperDetail mobileViewCart">
                            <div class="swiper-wrapper">
                                <div
                                    @click="viewProduct(product.id)"
                                    v-for="ProductDetailImg in ProductDetailImg"
                                    :key="ProductDetailImg.id"
                                    class="swiper-slide"
                                >
                                    <img
                                        class="image-detail"
                                        :src="
                                            '/images/' + ProductDetailImg.image
                                        "
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
            </div>
        </div>
    </div>
    <LoadingSpinner :isLoading="isLoading" />
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import LoadingSpinner from "../components/layout/LoadingSpinner.vue";

export default {
    components: {
        LoadingSpinner,
    },
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        productId: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            product: {},
            sizes: [],
            colors: [],
            soldQuantity: 0,
            ProductDetailImg: [],
            isLoading: false,
            discountPercent: 0,
            productVariant: [],
            productInfor: [],
            ProductDetail: [],
            ProductDetails: [],
        };
    },
    computed: {
        productUrl() {
            return `/api/product/view/${this.productId}`;
        },
        ...mapGetters(["formatCurrency"]),
    },
    methods: {
        closeModal() {
            this.isLoading = false;
            this.$emit("close");
        },
        async fetchProductDetails() {
            this.isLoading = true;
            try {
                const response = await axios.get(this.productUrl);
                // console.log(response.data);
                if (response.data.success == true) {
                    this.isLoading = false;
                    this.ProductDetailImg = response.data.ProductDetailImg;
                    this.ProductDetail = response.data.product_info;
                    this.ProductDetails = response.data.productDetails;
                    this.product = response.data.product;
                    this.sizes = response.data.sizes;
                    this.colors = response.data.colors;
                    this.soldQuantity = response.data.product.sales_count;
                    this.discountPercent = this.product.discount;
                    this.$nextTick(() => {
                        this.includeSwiper();
                    });
                }
            } catch (error) {
                this.isLoading = false;
                console.error("Error:", error);
            }
        },
        viewProduct(id) {
            this.$emit("close");
            this.$router.push({
                name: "ViewProduct",
                params: { id: id },
            });
        },
        includeSwiper() {
            if (this.swiper) {
                this.swiper.destroy(true, true);
            }
            this.swiper = new Swiper(".mySwiperDetail", {
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
    watch: {
        show(newVal) {
            if (newVal) {
                this.fetchProductDetails();
            }
        },
    },
    emits: ["close"],
};
</script>

<style scoped>
.modal-detail-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-detail-content {
    background-color: #fff;
    padding-left: 18px;
    border-radius: 10px;
    max-width: 80%;
    max-height: 80vh;
    overflow-y: auto;
    position: relative;
}

.close-detail-button {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 38px;
    cursor: pointer;
    z-index: 9999 !important;
    cursor: pointer;
    padding-right: 5px;
    padding-left: 5px;
    color: black;
}

.product-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}

@media only screen and (max-width: 768px) {
    .modal-detail-content {
        max-width: 96%;
        max-height: 90vh;
    }
    .close-detail-button {
        position: static;
        display: flex;
        justify-content: end;
        font-size: 30px;
    }
}
</style>
