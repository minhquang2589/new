<template>
    <Dashboard page-title="Size chart - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="sizeUpdate">
            <div class="lg:flex justify-center">
                <div class="w-full mx-4">
                    <div class="">
                        <div class="flex mb-5 items-center gap-4">
                            <img
                                :src="imagePreviewUrl"
                                class="size-28 rounded object-cover"
                            />
                            <button
                                type="button"
                                @click="triggerFileInput"
                                class="rounded hover:underline"
                            >
                                Change
                            </button>
                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFileUpload"
                                class="hidden"
                            />
                        </div>
                        <div class="mt-4">
                            <div class="w-full mr-5">
                                <select
                                    id="class"
                                    for="class"
                                    name="class"
                                    v-model="cate_name"
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
                </div>
            </div>
        </form>
    </Dashboard>
</template>
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import Dashboard from "@/components/Dashboard.vue";
export default {
    name: "editSizeChart",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            cate_name: "",
            imagePreviewUrl: null,
            fileName: "",
        };
    },
    mounted() {
        this.getSectionData();
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),

        async getSectionData() {
            try {
                const response = await axios.get(
                    `/api/size/edit/${this.$route.params.id}`
                );
                //   console.log(response.data);
                if (response.data.success == true) {
                    this.cate_name = response.data.data.cate_name;
                    this.imagePreviewUrl = `/images/${response.data.data.image_url}`;
                } else {
                    console.log("shop edit error.");
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.imagePreviewUrl = reader.result;
                };
                reader.readAsDataURL(file);
            }
            this.fileName = [file];
        },
        async sizeUpdate() {
            let formData = new FormData();
            formData.append("cate_name", this.cate_name);
            formData.append("image", this.fileName[0]);
            formData.append("id", this.$route.params.id);
            axios
                .post("/api/size/update", formData, {
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
