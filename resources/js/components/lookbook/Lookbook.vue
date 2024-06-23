<template>
    <div class="lg:mt-20 lg:mb-4 mb-3 mt-10 flex justify-center">
        <div>
            <h1 class=" text-xl font-bold text-gray-900 lg:text-3xl">
                Lookbooks
            </h1>
        </div>
    </div>
    <div class="grid grid-cols-1 mt-20 px-3 lg:px-10 gap-2 lg:grid-cols-4">
        <template v-for="(item, index) in dataLookbook">
            <div class="rounded-lg">
                <div
                    class="hover:cursor-pointer block"
                    @click="viewLookbook(item.id)"
                >
                    <img
                        :src="`/images/${item.first_image}`"
                        :alt="item.first_image"
                        class="h-[600px] w-full object-cover sm:h-[680px]"
                    />
                    <div class="mt-3 flex">
                        <div>
                            <h3 class="text-black font-bold">
                                {{ item.title }}
                            </h3>

                            <p class="mt-1.5 text-pretty text-sm text-gray-500">
                                {{ item.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div class="mt-10" v-if="dataLookbook != null && dataLookbook.length > 0">
        <div
            v-if="hasMore"
            class="flex mt-2 w-full items-center justify-center"
        >
            <button @click="loadMore" class="text-gray-800 text-xs lg:text-sm">
                Loading...
            </button>
        </div>
        <div v-else class="flex mt-2 w-full items-center justify-center">
            <span class="text-gray-800 text-xs lg:text-sm"> end </span>
        </div>
    </div>
    <LoadingSpinner :isLoading="isLoading" />
</template>
<script>
import LoadingSpinner from "../layout/LoadingSpinner.vue";
export default {
    name: "Lookbook",
    components: {
        LoadingSpinner,
    },
    data() {
        return {
            page: 1,
            perPage: 36,
            hasMore: true,
            isLoading: false,
            dataLookbook: [],
            isLoading: true,
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
        viewLookbook(id) {
            this.$router.push({
                name: "viewLookbook",
                params: { id: id },
            });
        },
        async fetchData() {
            this.isLoading = true;
            try {
                const response = await axios.get(
                    `/api/get-lookbook?page=${this.page}`
                );
                // console.log(response.data);
                if (response.data.success == true) {
                    const LookbookData = response.data.lookbookViews;
                    if (LookbookData.length < this.perPage) {
                        this.hasMore = false;
                    }
                    this.dataLookbook = LookbookData;
                    this.isLoading = false;
                }
            } catch (error) {
                this.isLoading = false;
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
    },
};
</script>
