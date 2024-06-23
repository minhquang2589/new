<template>
    <Dashboard page-title="Vouchers - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="sectionUpdate">
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
                        <div class="relative z-0 mb-2 group">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-model="name"
                                class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                placeholder="Name"
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
                        <div class="mt-2">
                            <textarea
                                class="w-full border rounded-lg border-gray-700 p-3 text-sm"
                                placeholder="Description...."
                                rows="4"
                                lg:row="9"
                                v-model="description"
                            ></textarea>
                        </div>
                        <div class="mt-2">
                            <label>
                                <input
                                    class="size-4 rounded border-gray-300"
                                    type="checkbox"
                                    name="status"
                                    v-model="status"
                                    :checked="status === 1"
                                />
                                <span for="status" class="text-red-600 ml-3"
                                    >Status</span
                                >
                            </label>
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
    name: "editSection",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            status: false,
            name: "",
            description: "",
            link_url: "",
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
                const sectionId = this.$route.params.id;
                const response = await axios.get(
                    `/api/section/edit/${sectionId}`
                );
                //  console.log(response.data);
                if (response.data.success == true) {
                    this.name = response.data.dataSection.name;
                    this.link_url = response.data.dataSection.link_url;
                    this.description = response.data.dataSection.description;
                    this.status = response.data.dataSection.status;
                    this.imagePreviewUrl = `/images/${response.data.dataSection.image}`;
                } else {
                    console.log("voucher edit error.");
                }
            } catch (error) {
                console.error("Error fetching voucher data:", error);
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
        async sectionUpdate() {
            const sectionId = this.$route.params.id;
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("link_url", this.link_url);
            formData.append("description", this.description);
            formData.append("status", this.status ? 1 : 0);
            formData.append("image", this.fileName[0]);
            formData.append("sectionId", sectionId);
            axios
                .post("/api/section/update", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    //   console.log(response.data);
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
