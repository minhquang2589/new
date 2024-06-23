<template>
    <Dashboard page-title="Slider bag - Upload">
        <form class="max-w-md mx-auto" @submit.prevent="SliderBagUpload">
            <div class="lg:flex justify-center">
                <div class="w-full mx-4">
                    <div class="">
                        <div class="relative z-0 mb-2 group">
                            <input
                                type="text"
                                name="link_url"
                                id="link_url"
                                v-model="link_url"
                                class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                placeholder="Link url"
                            />
                        </div>
                        <div class="mt-2">
                            <textarea
                                class="w-full border rounded-lg border-gray-400 p-3 text-sm"
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
import Dashboard from "@/components/Dashboard.vue";
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    name: "sliderBagUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            status: false,
            link_url: "",
            description: "",
        };
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),
        async SliderBagUpload() {
            let formData = new FormData();
            formData.append("link_url", this.link_url);
            formData.append("description", this.description);
            formData.append("status", this.status ? 1 : 0);

            axios
                .post("/api/slider-bag/upload", formData, {
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
