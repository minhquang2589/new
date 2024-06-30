<template>
    <div class="lg:px-10 px-2 bg-white">
        <div
            class="shadow-xl mx-auto rounded-md mb-10 max-w-screen"
            v-if="
                dataSlider != null && dataSlider.length >= 2 && dataBag != null
            "
        >
            <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-6">
                <div
                    class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-stretch"
                >
                    <div
                        class="grid place-content-center rounded bg-gray-50 p-6 sm:p-8"
                    >
                        <div class="mx-auto max-w-md text-center lg:text-left">
                            <div>
                                <h2
                                    @click="navigateToUrl(dataBag.link_url)"
                                    class="text-xl uppercase font-bold text-gray-900 sm:text-3xl"
                                >
                                    Bag
                                </h2>

                                <p
                                    class="mt-4 text-xs font-medium uppercase text-gray-600"
                                >
                                    {{ dataBag.description }}
                                </p>
                            </div>

                            <a
                                @click="navigateToUrl(dataBag.link_url)"
                                href="#"
                                class="mt-8 inline-block rounded border border-gray-900 bg-gray-900 px-12 py-3 text-sm font-medium text-white transition hover:shadow focus:outline-none focus:ring"
                            >
                                Shop All
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-2 lg:py-8">
                        <ul class="grid grid-cols-2 gap-4">
                            <template v-for="(item, index) in dataSlider">
                                <li>
                                    <a
                                        href="#"
                                        @click="viewProduct(item.id,item.name)"
                                        class="group block"
                                    >
                                        <img
                                            :src="`/images/${item.image}`"
                                            :alt="item.image"
                                            class="aspect-square w-full group-hover:scale-105 transition duration-500 rounded object-cover"
                                        />

                                        <div class="mt-3">
                                            <h3
                                                class="font-medium text-gray-900 group-hover:underline group-hover:underline-offset-4"
                                            >
                                                {{ item.name }}
                                            </h3>

                                            <p
                                                class="mt-1 text-sm text-gray-700"
                                            >
                                                {{
                                                    this.formatCurrency(
                                                        item.price
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapMutations, mapActions, mapState } from "vuex";

export default {
    name: "SliderBag",
    data() {
        return {
            dataBag: null,
            dataSlider: [],
        };
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                const response = await axios.get(`/api/slider-bag`);
                // console.log(response.data);
                if (response.data.success == true) {
                    this.dataBag = response.data.dataBag;
                    this.dataSlider = response.data.data;
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        navigateToUrl(url) {
            if (url) {
                window.location.href = url;
            }
        },
        viewProduct(id, name) {
            const productName = name.replace(/\s+/g, "-").toLowerCase();
            this.$router.push({
                name: "ViewProduct",
                params: { id: id, productName: productName },
            });
        },
    },
};
</script>
