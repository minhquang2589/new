<template>
    <div
        class="grid mt-10 grid-cols-1 lg:px-10 px-1 gap-4 lg:grid-cols-2 lg:gap-8"
    >
        <div class="rounded-lg">
            <div
                class="z-1 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32"
            >
                <div
                    class="mt-10 lg:flex lg:justify-center lg:items-center mx-auto max-w-9xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28"
                >
                    <div class="sm:text-center lg:text-left">
                        <div class="w-full lg:col-span-1">
                            <div v-html="about.content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-full rounded-lg">
            <img :src="`images/${about.image}`" />
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "About",
    data() {
        return {
            about: {},
        };
    },
    mounted() {
        axios
            .get("/api/store-info")
            .then((response) => {
                // console.log(response.data);
                if (response.data.success == true) {
                    this.about = response.data.store;
                }
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
};
</script>
