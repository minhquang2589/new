<template>
    <Dashboard page-title="Contact - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="contactUpdate">
            <div class="max-w-lg">
                <input
                    type="text"
                    name="link_url"
                    v-model="link_url"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                    placeholder="Link url to web"
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
    name: "contactEdit",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            link_url: "",
            content: "",
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
        async fetchData() {
            try {
                const response = await axios.get(
                    `/api/contact-edit/${this.$route.params.id}`
                );
                // console.log(response.data);
                if (response.data.success == true) {
                    this.content = response.data.data.content;
                    this.link_url = response.data.data.link_url;
                    if (this.editorInstance) {
                        this.editorInstance.setData(this.content);
                    }
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        contactUpdate() {
            let formData = new FormData();
            formData.append("content", this.content);
            formData.append("link_url", this.link_url);
            formData.append("id", this.$route.params.id);
            axios
                .post("/api/contact/update", formData, {
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
