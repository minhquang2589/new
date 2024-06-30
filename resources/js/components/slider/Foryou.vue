<template>
    <div v-if="sliderForyouData.length > 0" class="my-4 lg:my-10">
        <div class="bg-gray-50 shadow-xl">
            <div class="mx-auto py-12 lg:py-10 xl:py-14">
                <div
                    class="max-w-7xl pl-4 lg:pl-24 items-end justify-between sm:flex sm:pe-6 lg:pe-8"
                >
                    <h2
                        class="max-w-xl uppercase text-xl lg:text-4xl font-black tracking-tight text-gray-900 sm:text-5xl"
                    >
                        Products for you
                    </h2>

                    <div class="mt-8 flex gap-4 lg:mt-0">
                        <button
                            aria-label="Previous slide"
                            id="keen-slider-previous"
                            class="rounded-full border border-black p-3 text-black transition"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5 rtl:rotate-180"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5"
                                />
                            </svg>
                        </button>
                        <button
                            aria-label="Next slide"
                            id="keen-slider-next"
                            class="rounded-full border border-black p-3 text-black transition"
                        >
                            <svg
                                class="size-5 rtl:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M9 5l7 7-7 7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-8 lg:col-span-2 lg:mx-0">
                    <div
                        id="keen-slider"
                        class="keen-slider flex overflow-hidden"
                    >
                        <div
                            class="keen-slider__slide"
                            v-for="value in sliderForyouData"
                            :key="value.id"
                        >
                            <div
                                @click="viewProduct(value.id, value.name)"
                                class="group flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
                            >
                                <div>
                                    <div class="mt-4">
                                        <p
                                            class="lg:text-2xl font-bold text-rose-600"
                                        >
                                            {{ value.name }}
                                        </p>

                                        <p
                                            class="mt-4 leading-relaxed text-gray-700"
                                        >
                                            <img
                                                :src="`/images/${value.image}`"
                                                :alt="value.image"
                                                class="aspect-square group-hover:scale-105 transition duration-500 w-full rounded object-cover"
                                            />
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="mt-4 flex text-sm font-medium text-gray-700 sm:mt-6"
                                >
                                    <span
                                        class="group-hover:underline group-hover:underline-offset-2"
                                        >{{
                                            this.formatCurrency(value.price)
                                        }}</span
                                    >
                                    <div class="ml-5">
                                        <span
                                            v-if="value.is_new"
                                            class="rounded-full mr-1 text-white bg-red-600 px-1 py-0.5 lg:px-1.5 lg:py-1 text-xs font-medium"
                                        >
                                            New
                                        </span>
                                        <span
                                            v-if="value.discount > 0"
                                            class="rounded-full text-white bg-red-600 px-1 py-0.5 lg:px-1.5 lg:py-1 text-xs font-medium"
                                        >
                                            - {{ value.discount }} %
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import KeenSlider from "https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm";
import { mapGetters, mapMutations, mapActions, mapState } from "vuex";

export default {
    data() {
        return {
            sliderForyouData: [],
            keenSlider: null,
        };
    },
    mounted() {
        this.fetchingData();
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    methods: {
        viewProduct(id, name) {
            const productName = name.replace(/\s+/g, "-").toLowerCase();
            this.$router.push({
                name: "ViewProduct",
                params: { id: id, productName: productName },
            });
        },
        async fetchingData() {
            try {
                const response = await axios.get(`/api/slider-foryou`);
                //  console.log(response.data);
                if (response.data.success) {
                    this.sliderForyouData = response.data.data;
                    this.$nextTick(() => {
                        this.iniSlider();
                    });
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        iniSlider() {
            const animation = { duration: 18000, easing: (t) => t };
            this.keenSlider = new KeenSlider("#keen-slider", {
                loop: true,
                renderMode: "performance",
                drag: false,
                slides: {
                    origin: "center",
                    perView: 1.4,
                    spacing: 23,
                },
                breakpoints: {
                    "(min-width: 1024px)": {
                        slides: {
                            origin: "auto",
                            perView: 2.5,
                            spacing: 32,
                        },
                    },
                },
                created(s) {
                    s.moveToIdx(5, true, animation);
                },
                updated(s) {
                    s.moveToIdx(s.track.details.abs + 5, true, animation);
                },
                animationEnded(s) {
                    s.moveToIdx(s.track.details.abs + 5, true, animation);
                },
            });
            const keenSliderPrevious = document.getElementById(
                "keen-slider-previous"
            );
            const keenSliderNext = document.getElementById("keen-slider-next");
            keenSliderPrevious.addEventListener("click", () =>
                this.keenSlider.prev()
            );
            keenSliderNext.addEventListener("click", () =>
                this.keenSlider.next()
            );
        },
    },
};
</script>
