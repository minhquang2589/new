<template>
    <Dashboard page-title="About - Upload">
        <form class="max-w-md mx-auto" @submit.prevent="aboutUpload">
            <div class="max-w-lg">
                <label
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    for="images"
                    >Store image</label
                >
                <input
                    require
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="images"
                    for="images"
                    type="file"
                    id="image-input"
                    name="images[]"
                    multiple
                    @change="handleImageUpload"
                />
            </div>
            <div class="mt-3">
                <textarea class="w-full" name="content" id="editor"></textarea>
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
            <div class="mb-5 mt-2 w-full">
                <div class="flex py-3 justify-start lg:flex lg:justify-start">
                    <button
                        type="submit"
                        class="block mr-2 rounded-xl bg-gray-800 px-8 py-2 text-sm text-white transition hover:bg-black"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </Dashboard>
</template>
<script>
import Dashboard from "@/components/Dashboard.vue";
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    name: "aboutUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            content: "",
        };
    },
    mounted() {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const uploadUrl = "/api/upload/product/file?_token=" + csrfToken;

        ClassicEditor.create(document.querySelector("#editor"), {
            ckfinder: {
                uploadUrl: uploadUrl,
            },
        })
            .then((editor) => {
                editor.model.document.on("change", () => {
                    this.content = editor.getData();
                });
            })
            .catch((error) => {
                console.error(error);
            });
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
        async aboutUpload() {
            const file = this.images[0];
            let formData = new FormData();
            formData.append("content", this.content);
            formData.append("images", file);

            axios
                .post("/api/store/upload", formData, {
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
