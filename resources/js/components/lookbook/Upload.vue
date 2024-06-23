<template>
    <Dashboard page-title="Lookbooks - Upload">
        <form class="max-w-md mx-auto" @submit.prevent="lookbookUpload">
            <div class="relative z-0 w-full mb-5 mt-4 group">
                <input
                    type="text"
                    name="title"
                    id="title"
                    v-model="title"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                    placeholder="Title"
                />
                <input
                    type="text"
                    name="description"
                    id="description"
                    v-model="description"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                    placeholder="Description"
                />
            </div>
            <div class="mt-3">
                <textarea class="w-full" name="content" id="editor"></textarea>
            </div>
            <div class="mt-2">
                <label>
                    <input
                        class="size-4 rounded border-gray-300"
                        type="checkbox"
                        name="status"
                        v-model="status"
                    />
                    <span for="status" class="text-red-600 ml-3">Status</span>
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
    name: "lookbookUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            status: false,
            title: "",
            description: "",
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
        async lookbookUpload() {
            let formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("content", this.content);
            formData.append("status", this.status ? 1 : 0);

            axios
                .post("/api/lookbook/upload", formData, {
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
