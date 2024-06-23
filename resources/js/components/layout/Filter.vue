<template>
    <div class="space-y-2">
        <div class="overflow-hidden rounded border border-gray-400">
            <div
                class="flex items-center justify-between gap-2 bg-white p-4 text-gray-900 transition"
            >
                <span class="text-sm font-medium">Filter</span>
            </div>
            <div class="border-t border-gray-200 p-4">
                <div>
                    <label for="priceFrom" class="flex items-center gap-2">
                        <input
                            type="number"
                            v-model="priceFrom"
                            id="priceFrom"
                            placeholder="From"
                            class="w-full border py-0.5 rounded-md border-gray-200 shadow-sm sm:text-sm"
                            @input="updateFilters"
                        />
                        <span class="text-sm text-gray-600">đ</span>
                    </label>
                    <label for="priceTo" class="flex mt-2 items-center gap-2">
                        <input
                            type="number"
                            id="priceTo"
                            v-model="priceTo"
                            placeholder="To"
                            class="w-full rounded-md py-0.5 border border-gray-200 shadow-sm sm:text-sm"
                            @input="updateFilters"
                        />
                        <span class="text-sm text-gray-600">đ</span>
                    </label>
                </div>
            </div>
            <ul class="space-y-1 border-t border-gray-200 p-4">
                <li>
                    <label
                        for="filternew"
                        class="inline-flex items-center gap-2"
                    >
                        <input
                            type="checkbox"
                            v-model="filternew"
                            class="size-4 rounded border-gray-300"
                            @change="updateFilters"
                        />
                        <div class="flex">
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >New</span
                            >
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >({{ newCount }})</span
                            >
                        </div>
                    </label>
                </li>
                <li>
                    <label
                        for="filterDiscount"
                        class="inline-flex items-center gap-2"
                    >
                        <input
                            type="checkbox"
                            v-model="filterDiscount"
                            class="size-4 rounded border-gray-300"
                            @change="updateFilters"
                        />
                        <div class="flex">
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >Discount</span
                            >
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >({{ discountCount }})</span
                            >
                        </div>
                    </label>
                </li>
                <li>
                    <label
                        for="filterinstock"
                        class="inline-flex items-center gap-2"
                    >
                        <input
                            type="checkbox"
                            v-model="filterinstock"
                            class="size-4 rounded border-gray-300"
                            @change="updateFilters"
                        />
                        <div class="flex">
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >In Stock</span
                            >
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >({{ inStockCount }})</span
                            >
                        </div>
                    </label>
                </li>
                <li>
                    <label
                        for="filteroutofstock"
                        class="inline-flex items-center gap-2"
                    >
                        <input
                            type="checkbox"
                            v-model="filteroutofstock"
                            class="size-4 rounded border-gray-300"
                            @change="updateFilters"
                        />
                        <div class="flex">
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >Out of Stock</span
                            >
                            <span class="text-sm mr-1 font-medium text-gray-700"
                                >({{ OutOfStockCount }})</span
                            >
                        </div>
                    </label>
                </li>
            </ul>
            <ul class="space-y-1 border-t border-gray-200 p-2">
                <li>
                    <div class="flex py-1 justify-center">
                        <button
                            id="resetFilters"
                            type="button"
                            class="text-sm text-gray-900 hover:underline"
                            @click="resetFilters"
                        >
                            Reset
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "Filter",
    props: {
        categoryProp: String,
    },
    data() {
        return {
            category: "",
            searchKey: null,
            priceFrom: null,
            priceTo: null,
            filternew: false,
            filterDiscount: false,
            filterinstock: false,
            filteroutofstock: false,
            discountCount: 0,
            newCount: 0,
            inStockCount: 0,
            OutOfStockCount: 0,
        };
    },
    mounted() {
        this.fetchFilterContent(this.categoryProp);
    },
    methods: {
        fetchFilterContent(category) {
            axios
                .get(`/api/filter/content/${category}`)
                .then((response) => {
                    // console.log(response.data);
                    this.newCount = response.data.newCount;
                    this.discountCount = response.data.discountCount;
                    this.inStockCount = response.data.instockCount;
                    this.OutOfStockCount = response.data.outstockCount;
                })
                .catch((error) => {});
        },
        updateFilters() {
            const filters = {
                searchKey: this.searchKey,
                priceFrom: this.priceFrom,
                priceTo: this.priceTo,
                filternew: this.filternew,
                filterDiscount: this.filterDiscount,
                instock: this.filterinstock,
                outofstock: this.filteroutofstock,
            };
            this.$emit("updateFilters", filters);
        },
        resetFilters() {
            this.searchKey = null;
            this.priceFrom = null;
            this.priceTo = null;
            this.filternew = false;
            this.filterDiscount = false;
            this.filterinstock = false;
            this.filteroutofstock = false;
            this.updateFilters();
        },
    },
};
</script>
