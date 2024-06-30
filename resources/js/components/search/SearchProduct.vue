<template>
    <transition name="overlay">
        <div v-if="show" class="overlay-search" @click="closeSearch">
            <transition name="slide">
                <div class="search-container rounded-lg" @click.stop>
                    <div class="flex justify-start mb-4 ml-3">
                        <button @click="closeSearch" class="search-button">
                            &times;
                        </button>
                    </div>
                    <div class="flex">
                        <div class="input-container">
                            <input
                                class="border border-gray-400"
                                v-model="query"
                                @keyup.enter="executeSearch"
                                @input="debouncedSearch()"
                                placeholder="Search for products..."
                            />
                            <LoadingButton
                                class="loading-button"
                                :loading="isLoadingButton"
                            >
                                <button
                                    @click="executeSearch"
                                    class="hidden"
                                ></button>
                            </LoadingButton>
                        </div>
                    </div>
                    <div v-if="results.length && resultQuantity">
                        <div
                            class="relative w-full border overflow-hidden rounded-lg border-gray-300 px-4 py-8 sm:px-6 lg:px-8"
                        >
                            <div class="mt-1 space-y-3">
                                <ul class="space-y-3 overflow-y-auto">
                                    <li
                                        class="flex rounded border hover:cursor-pointer hover:border-gray-800 items-center gap-4"
                                        v-for="value in results"
                                        :key="value.id"
                                        @click="
                                            viewProduct(value.id, value.name)
                                        "
                                    >
                                        <img
                                            :src="`/images/${value.image}`"
                                            :alt="value.name"
                                            class="size-16 rounded object-cover"
                                        />
                                        <div>
                                            <h3
                                                class="text-sm"
                                                v-html="
                                                    wrapQueryInBold(
                                                        value.name,
                                                        query
                                                    )
                                                "
                                            ></h3>
                                            <dl
                                                class="mt-0.5 space-y-px text-[10px] text-gray-600"
                                            >
                                                <div class="flex">
                                                    <div>
                                                        <dt class="inline">
                                                            Price:
                                                        </dt>
                                                        <dd class="inline">
                                                            {{
                                                                this.formatCurrency(
                                                                    value.price
                                                                )
                                                            }}
                                                        </dd>
                                                    </div>
                                                    <div
                                                        class="ml-1"
                                                        v-if="
                                                            value.discount &&
                                                            value.discount_quantity >
                                                                0
                                                        "
                                                    >
                                                        <dt class="inline">
                                                            -
                                                        </dt>
                                                        <dd class="inline">
                                                            {{
                                                                value.discount
                                                            }}%
                                                        </dd>
                                                    </div>
                                                </div>
                                            </dl>
                                        </div>
                                    </li>
                                </ul>
                                <div class="space-y-1 text-center">
                                    <span
                                        @click="executeSearch"
                                        class="block hover:cursor-pointer rounded border border-gray-400 hover:border-black py-2 text-sm text-gray-600 transition hover:ring-1 hover:ring-gray-400"
                                    >
                                        View all ({{ resultQuantity }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="checkResult && resultQuantity <= 0"
                        class="flex justify-center text-sm"
                    >
                        No products were found matching your selection.
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
import { mapGetters } from "vuex";
import LoadingButton from "../layout/LoadingButton.vue";

export default {
    components: { LoadingButton },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            query: "",
            results: [],
            resultQuantity: 0,
            checkResult: false,
            debounceTimeout: null,
            isLoadingButton: false,
        };
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    methods: {
        wrapQueryInBold(text, query) {
            const regex = new RegExp(`(${query})`, "gi");
            return text.replace(regex, "<strong>$1</strong>");
        },
        async searchItems() {
            this.checkResult = false;
            if (this.query !== "") {
                this.isLoadingButton = true;
                try {
                    const response = await axios.get(
                        `/api/products/search-chill`,
                        {
                            params: { query: this.query },
                        }
                    );
                    // console.log(response.data);
                    if (response.data.success) {
                        this.results = response.data.data;
                        this.resultQuantity = response.data.resultQuantity;
                        if (this.resultQuantity <= 0) {
                            this.checkResult = true;
                            this.isLoadingButton = false;
                        }
                        this.isLoadingButton = false;
                    }
                } catch (error) {
                    this.results = [];
                    this.isLoadingButton = false;
                    // console.error("Error:", error);
                }
            } else {
                this.results = [];
            }
        },
        debouncedSearch() {
            clearTimeout(this.debounceTimeout);
            this.debounceTimeout = setTimeout(() => {
                this.searchItems();
            }, 600);
        },
        executeSearch() {
            this.checkResult = false;
            if (this.query !== "") {
                this.$emit("close");
                this.$router.push({
                    name: "SearchResults",
                    query: { query: this.query },
                });
            }
        },
        closeSearch() {
            this.checkResult = false;
            this.query = "";
            this.results = [];
            this.$emit("close");
        },
        viewProduct(id, name) {
            this.$emit("close");
            const productName = name.replace(/\s+/g, "-").toLowerCase();
            this.$router.push({
                name: "ViewProduct",
                params: { id: id, productName: productName },
            });
        },
    },
};
</script>
<style scoped>
.input-container {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

.input-container input {
    flex: 1;
    font-size: 1rem;
    border-radius: 7px;
}

.input-container .loading-button {
    position: absolute;
    right: 27px;
    margin-bottom: 10px;
}
.overlay-search {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.search-button {
    font-size: 24px;
    cursor: pointer;
    z-index: 9999 !important;
    cursor: pointer;
    color: black;
}

.search-container {
    width: 40%;
    max-height: 80%;
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    transform: translateY(0);
    transition: transform 0.3s ease, opacity 0.3s ease;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    overflow-y: auto;
}

.search-container input {
    padding: 5px;
    padding-left: 15px;
    padding-right: 50px;
    margin-bottom: 10px;
    width: 100%;
    font-family: sans-serif;
}

@media only screen and (max-width: 768px) {
    .search-container {
        width: 95%;
    }
    .search-container input {
        padding-left: 10px;
    }
}

.overlay-enter-active,
.overlay-leave-active {
    transition: opacity 0.5s ease;
}

.overlay-enter,
.overlay-leave-to {
    opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
    transition: transform 0.5s ease, opacity 0.5s ease;
}

.slide-enter,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
