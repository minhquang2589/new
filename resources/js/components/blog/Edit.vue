<template>
    <Dashboard page-title="Blog - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="blogUpdate">
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
                        ref="fileInput"
                        @change="handleImageUpload"
                        class="hidden"
                        aria-describedby="images"
                        for="images"
                        type="file"
                        id="image-input"
                        name="images[]"
                        multiple
                        require
                    />
                </div>
            </div>
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
                <textarea
                    class="w-full"
                    v-model="content"
                    name="content"
                    id="editor"
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
import { mapGetters, mapMutations, mapActions } from "vuex";
import Dashboard from "@/components/Dashboard.vue";
export default {
    name: "EditBlog",
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
            imagePreviewUrl: null,
        };
    },
    mounted() {
        this.getBlogData();
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

        async getBlogData() {
            try {
                const response = await axios.get(
                    `/api/blog/edit/${this.$route.params.id}`
                );
                // console.log(response.data);
                if (response.data.success == true) {
                    this.title = response.data.blog.title;
                    this.description = response.data.blog.description;
                    this.status = response.data.blog.status;
                    this.images = response.data.blog.image_url;
                    this.content = response.data.blog.content;
                    this.imagePreviewUrl = `/images/${response.data.blog.image_url}`;
                    if (this.editorInstance) {
                        this.editorInstance.setData(this.content);
                    }
                } else {
                    console.log("voucher edit error.");
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.imagePreviewUrl = reader.result;
                };
                reader.readAsDataURL(file);
            }
            this.images = [file];
        },
        async blogUpdate() {
            const file = this.images[0];
            const blogId = this.$route.params.id;
            let formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("content", this.content);
            formData.append("status", this.status ? 1 : 0);
            formData.append("images", file);
            formData.append("blogId", blogId);

            axios
                .post("/api/blog/update", formData, {
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
