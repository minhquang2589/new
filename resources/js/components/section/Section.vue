<template>
    <div v-if="section.name && section.image">
        <div
            class="lg:flex lg:justify-center w-full px-2 lg:px-10 lg:my-20 my-16"
        >
            <div
                class="overflow-hidden rounded-lg shadow-2xl md:grid md:grid-cols-3"
            >
                <img
                    @click="navigateToUrl(section.link_url)"
                    :src="`/images/${section.image}`"
                    class="w-full object-cover duration-500 md:h-full hover:cursor-pointer transition hover:scale-105"
                />
                <div
                    class="flex justify-center items-center w-full md:col-span-2"
                >
                    <div class="p-4 text-center sm:p-6 lg:p-8">
                        <h2 class="mt-6 font-black uppercase">
                            <span
                                class="text-4xl font-black sm:text-5xl lg:text-6xl"
                            >
                                {{ section.name }}
                            </span>

                            <p
                                class="mt-8 text-xs font-medium uppercase text-gray-600"
                            >
                                {{ section.description }}
                            </p>
                        </h2>

                        <span
                            class="mt-8 hover:cursor-pointer rounded inline-block w-full bg-black py-4 text-sm font-bold uppercase tracking-widest text-white"
                            @click="navigateToUrl(section.link_url)"
                        >
                            Shopping
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Section",
    data() {
        return {
            section: {},
        };
    },
    mounted() {
        axios
            .get("/api/section")
            .then((response) => {
                if (response.data.success == true) {
                    this.section = response.data.section;
                }
            })
            .catch((error) => {
                console.error("Error fetching section data:", error);
            });
    },
    methods: {
        navigateToUrl(url) {
            if (url) {
                window.location.href = url;
            }
        },
    },
};
</script>

<style scoped>
.image_section {
    z-index: 1;
}
</style>
