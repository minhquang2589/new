<template>
    <Dashboard page-title="Lookbook - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="editLookbook">
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
    name: "editLookbook",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            description: "",
            content: "",
            title: "",
            images: [],
            status: false,
        };
    },
    mounted() {
        this.getDataLookbook();
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
        async getDataLookbook() {
            try {
                const response = await axios.get(
                    `/api/lookbook/edit/${this.$route.params.id}`
                );
                //  console.log(response.data);
                if (response.data.success == true) {
                    const dataLookbook = response.data.data;
                    this.description = dataLookbook.description;
                    this.title = dataLookbook.title;
                    this.content = dataLookbook.content;
                    this.status = dataLookbook.status;
                    if (this.editorInstance) {
                        this.editorInstance.setData(this.content);
                    }
                } else {
                    console.log("voucher edit error.");
                }
            } catch (error) {
                console.error("Error fetching voucher data:", error);
            }
        },
        async editLookbook() {
            const lookbookId = this.$route.params.id;
            let formData = new FormData();
            formData.append("id", lookbookId);
            formData.append("status", this.status ? 1 : 0);
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("content", this.content);
            axios
                .post("/api/lookbook-update", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    //   console.log(response.data);
                    if (response.data.success == true) {
                        this.showNotification(response.data.message);
                        this.getDataLookbook();
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
