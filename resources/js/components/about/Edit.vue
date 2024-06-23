<template>
    <Dashboard page-title="About - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="aboutUpdate">
            <div class="max-w-lg">
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
            </div>

            <div class="mt-3">
                <textarea
                    class="w-full"
                    v-model="content"
                    name="content"
                    id="editor"
                ></textarea>
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
import { mapGetters, mapMutations, mapActions } from "vuex";
import Dashboard from "@/components/Dashboard.vue";
export default {
    name: "editAbout",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            images: [],
            content: "",
            imagePreviewUrl: null,
        };
    },
    mounted() {
        this.fetchData();
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
                this.editorInstance = editor;
                editor.model.document.on("change", () => {
                    this.content = editor.getData();
                });
                if (this.content) {
                    editor.setData(this.content);
                }
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

        async fetchData() {
            try {
                const response = await axios.get(
                    `/api/about-edit/${this.$route.params.id}`
                );
                //  console.log(response.data);
                if (response.data.success == true) {
                    this.imagePreviewUrl = `/images/${response.data.data.image}`;
                    this.content = response.data.data.content;
                    if (this.editorInstance) {
                        this.editorInstance.setData(this.content);
                    }
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            this.images = [file];
        },
        aboutUpdate() {
            const file = this.images[0];
            let formData = new FormData();
            formData.append("content", this.content);
            formData.append("images", file);
            formData.append("id", this.$route.params.id);
            axios
                .post("/api/about/update", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    //  console.log(response.data);
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
