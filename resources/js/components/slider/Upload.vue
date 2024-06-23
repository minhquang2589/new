<template>
    <Dashboard page-title="Slider - Upload">
        <div class="lg:flex justify-center">
            <div class="w-full px-10 mt-10">
                <form @submit.prevent="sliderUpload">
                    <div class="">
                        <div class="relative z-0 mb-2 group">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-model="name"
                                class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                placeholder="Content"
                            />
                            <input
                                type="text"
                                name="link_url"
                                id="link_url"
                                v-model="link_url"
                                class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                placeholder="Link url"
                            />
                        </div>
                        <div class="mb-5">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                                for="content3"
                                >Image</label
                            >
                            <input
                                require
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="image"
                                for="images"
                                type="file"
                                id="image-input"
                                name="images[]"
                                multiple
                                @change="handleImageUpload"
                            />
                        </div>
                        <label>
                            <input
                                class="size-4 rounded border-gray-300"
                                type="checkbox"
                                name="status"
                                v-model="status"
                            />
                            <span for="status" class="text-red-600 ml-3"
                                >Status</span
                            >
                        </label>
                    </div>
                    <div
                        v-if="errorMessages.length"
                        class="error-messages mt-1 text-xs text-red-600"
                    >
                        <ul>
                            <li
                                class="mt-1"
                                v-for="(error, index) in errorMessages"
                                :key="index"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="flex justify-start lg:flex lg:justify-start">
                        <button
                            type="submit"
                            class="text-white mt-6 bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-1/2 sm:w-auto px-20 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Dashboard>
</template>
<script>
import Dashboard from "@/components/Dashboard.vue";
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    name: "SliderUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            status: false,
            name: "",
            link_url: "",
        };
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),
        handleImageUpload(event) {
            const file = event.target.files[0];
            this.images = [file];
        },
        async sliderUpload() {
            const file = this.images[0];
            let formData = new FormData();
            formData.append("link_url", this.link_url);
            formData.append("name", this.name);
            formData.append("status", this.status ? 1 : 0);
            formData.append("image", file);
            axios
                .post("/api/slider/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    // console.log(response.data);
                    if (response.data.success == true) {
                        this.showNotification(response.data.message);
                    } else {
                        this.errorMessages = response.data.error;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
