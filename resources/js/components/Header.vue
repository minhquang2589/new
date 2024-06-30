<template>
    <header class="z-10 w-full">
        <div v-if="isAdmin && userData">
            <AdminHeader />
        </div>
        <div v-show="isFilterOpen" class="overlay" @click="toggleFilter"></div>
        <div :class="{ 'view-cart-open': isFilterOpen }" class="view-cart">
            <FilterMobile
                :toggleFilter="toggleFilter"
            />
        </div>
        <div
            v-show="isViewCartOpen"
            class="overlay"
            @click="toggleViewCart"
        ></div>
        <div :class="{ 'view-cart-open': isViewCartOpen }" class="view-cart">
            <ViewCart :toggleViewCart="toggleViewCart" />
        </div>
        <div class="mx-auto max-w-screen-xl px-6 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="md:flex md:items-center mr-12 md:gap-12">
                    <router-link to="/">
                        <a class="block">
                            <img src="" alt="Logo" />
                        </a>
                    </router-link>
                </div>
                <div class="md:flex md:items-center md:gap-12"></div>
                <div class="hidden md:block">
                    <nav aria-label="Global">
                        <ul class="flex items-center gap-7 mr-10 text-sm">
                            <li class="dropdown-1">
                                <router-link to="/product">
                                    <a
                                        class="hover:text-gray-800 hover:underline"
                                        >Product</a
                                    >
                                </router-link>

                                <div
                                    id="dropdownMenu-1"
                                    class="dropdown-menu-1"
                                >
                                    <router-link to="/product/bestseller">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Best Seller</a
                                        >
                                    </router-link>
                                    <router-link to="/product/new">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >New Product</a
                                        >
                                    </router-link>
                                    <router-link to="/product/men">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Men's wear</a
                                        >
                                    </router-link>
                                    <router-link to="/product/women">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Women's wear</a
                                        >
                                    </router-link>
                                    <router-link to="/product/unisex">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >For unisex</a
                                        >
                                    </router-link>
                                    <router-link to="/product/discount">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Discount</a
                                        >
                                    </router-link>
                                </div>
                            </li>
                            <li class="dropdown-1">
                                <span>Shop </span>

                                <div
                                    id="dropdownMenu-1"
                                    class="dropdown-menu-1"
                                >
                                    <router-link to="/product/bag">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Bag</a
                                        >
                                    </router-link>
                                    <router-link to="/product/hat">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Hat</a
                                        >
                                    </router-link>
                                    <router-link to="/product/shoes">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Shoes</a
                                        >
                                    </router-link>
                                    <router-link to="/product/accessory">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Accessory</a
                                        >
                                    </router-link>
                                    <router-link to="/product/clothes">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Clothes</a
                                        >
                                    </router-link>
                                </div>
                            </li>
                            <li>
                                <router-link to="/about">
                                    <a
                                        class="hover:text-gray-800 hover:underline"
                                        href="#"
                                    >
                                        Store
                                    </a>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/blog">
                                    <a
                                        class="hover:text-gray-800 hover:underline"
                                        href="#"
                                    >
                                        Blog
                                    </a>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/contact">
                                    <a
                                        class="hover:text-gray-800 hover:underline"
                                        href="#"
                                        >Contact
                                    </a>
                                </router-link>
                            </li>
                            <li class="dropdown-1">
                                <span>Features </span>

                                <div
                                    id="dropdownMenu-1"
                                    class="dropdown-menu-1"
                                >
                                    <router-link to="/video">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Video</a
                                        >
                                    </router-link>
                                    <router-link to="/lookbook">
                                        <a
                                            class="dropdown-option-1 hover:text-gray-800"
                                            href="#"
                                            >Lookbook</a
                                        >
                                    </router-link>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div
                    class="flex justify-end xl:w-1/5 md:w-3/5 2xl:w-2/5 lg:w-1/5 gap-1 lg:gap-0 sm:gap-0 items-center"
                >
                    <div
                        class="rounded-2xl flex relative mt-2 lg:p-0 sm:p-0 py-2 text-sm font-medium transition sm:gap-1"
                    >
                        <div class="flex lg:mr-2 mr-0">
                            <div class="mb-3 relative flex items-center">
                                <button @click="toggleViewCart">
                                    <svg
                                        class="h-8 w-8 hover:cursor-pointer"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="38"
                                        height="30"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z"
                                        />
                                    </svg>
                                    <div
                                        class="absolute left-1/2 top-1/2 mt-1 transform -translate-x-1/2 -translate-y-1/2 text-lg"
                                    >
                                        {{ cartQuantity }}
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="hover:cursor-pointer filter-button ml-5">
                            <button @click="toggleFilter">
                                <div class="mt-2 relative flex items-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M19.479 2l-7.479 12.543v5.924l-1-.6v-5.324l-7.479-12.543h15.958zm3.521-2h-23l9 15.094v5.906l5 3v-8.906l9-15.094z"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div
                        @click="showSearch = true"
                        class="hover:cursor-pointer lg:ml-2 ml-3"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <SearchProduct :show="showSearch" @close="showSearch = false" />
</template>
<script>
import { inject, onMounted } from "vue";
import { mapGetters, mapMutations, mapActions } from "vuex";
import AdminHeader from "@/components/AdminHeader.vue";
import FilterMobile from "@/components/layout/FilterMobile.vue";
import ViewCart from "@/components/layout/ViewCart.vue";
import SearchProduct from "../components/search/SearchProduct.vue";
import Filter from "../components/layout/Filter.vue";

import axios from "axios";
export default {
    name: "Header",
    components: {
        AdminHeader,
        AdminHeader,
        FilterMobile,
        ViewCart,
        SearchProduct,
        Filter,
    },
    data() {
        return {
            isFilterOpen: false,
            isViewCartOpen: false,
            showSearch: false,
        };
    },
    created() {
        this.fetchCartQuantity();
    },
    computed: {
        ...mapGetters([
            "cart",
            "cartData",
            "userData",
            "cartQuantity",
            "isAdmin",
        ]),
    },
    methods: {
        ...mapActions(["fetchCart", "fetchCartData", "fetchCartQuantity"]),
        toggleFilter() {
            this.isFilterOpen = !this.isFilterOpen;
        },
        toggleViewCart() {
            this.isViewCartOpen = !this.isViewCartOpen;
            this.fetchCartQuantity();
            this.fetchCart();
            this.fetchCartData();
        },
    },
};
</script>
<style>
header {
    top: 0;
    left: 0;
    width: 100%;
    transition: top 1s;
    background: white;
    background-color: rgba(255, 255, 255, 0.9);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.28);
    position: sticky;
    z-index: 10;
}
.dropdown-1 {
    position: relative;
}

.dropdown-menu-1 {
    display: none;
    position: absolute;
    left: -50px;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    opacity: 0;
    transition: opacity 1.5s ease-out;
}

.dropdown-1:hover .dropdown-menu-1 {
    display: block;
    opacity: 1;
}

.dropdown-option-1 {
    display: flex;
    width: max-content;
    padding: 4px 60px 4px 10px;
    margin: 0px 7px;
}

.dropdown-option-1:hover {
    color: black;
    text-decoration: underline;
}
/* cart view */
.closecart {
    display: flex;
    justify-content: end;
}

.filter-button {
    display: none;
}
.filter_table {
    display: none;
}
@media only screen and (max-width: 768px) {
    .filter-button {
        display: block;
    }
    .filter_table {
        display: block;
        position: fixed;
        z-index: 9999;
        right: 0;
    }
}
</style>
