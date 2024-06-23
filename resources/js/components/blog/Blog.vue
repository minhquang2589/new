<template>
    <div
        v-if="blogData.content"
        class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased"
    >
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
            <article
                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert"
            >
                <div class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div
                            class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"
                        >
                            <img
                                class="mr-4 w-16 h-16 rounded-full"
                                :src="'/images/' + blogData.image_url"
                                alt="Avatar"
                            />
                            <div>
                                <p
                                    class="text-xl font-bold text-gray-900 dark:text-white"
                                >
                                    {{ blogData.title }}
                                </p>
                            </div>
                        </div>
                    </address>
                    <h1
                        class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"
                    >
                        {{ blogData.description }}
                    </h1>
                    <div v-html="blogData.content"></div>
                </div>
            </article>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Section",
    data() {
        return {
            blogData: {},
        };
    },
    mounted() {
        axios
            .get("/api/blog")
            .then((response) => {
                // console.log(response.data);
                if (response.data.success == true) {
                    this.blogData = response.data.blog;
                }
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
};
</script>
