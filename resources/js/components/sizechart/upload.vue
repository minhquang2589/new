<template>
    <Dashboard page-title="Size chart - Upload">
        <div class="lg:flex justify-center">
            <div class="w-full px-10 mt-10">
                <form @submit.prevent="sizeUpload">
                    <div class="">
                        <div class="mt-4">
                            <div class="w-full mr-5">
                                <select
                                    id="class"
                                    for="class"
                                    name="class"
                                    v-model="name"
                                    class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                                    <option hidden selected disabled>
                                        Choose a class
                                    </option>
                                    <option for="class" value="clothes">
                                        clothes
                                    </option>
                                    <option for="class" value="bag">bag</option>
                                    <option for="class" value="hat">hat</option>
                                    <option for="class" value="shoe">
                                        shoe
                                    </option>
                                    <option for="class" value="accessory">
                                        accessory
                                    </option>
                                </select>
                            </div>
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
    name: "sizeUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            name: "",
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
        async sizeUpload() {
            const file = this.images[0];
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("image", file);
            axios
                .post("/api/size/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log(response.data);
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
