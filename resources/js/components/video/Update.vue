<template>
    <Dashboard page-title="Video - Update">
        <div class="mx-6 lg:mx-0">
            <div class="flex justify-center">
                <table
                    class="lg:w-fit w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm"
                >
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Title
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Link vimeo url
                            </th>

                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Status
                            </th>

                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        v-for="value in data"
                        :key="value.id"
                        class="divide-y divide-gray-200"
                    >
                        <tr>
                            <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.title }}
                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.vimeo_video_url }}
                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                <p
                                    v-if="value.status == 1"
                                    class="flex justify-center rounded-full text-white bg-red-600 py-1 px-1 text-xs"
                                >
                                    Active
                                </p>
                                <p
                                    v-else
                                    class="flex justify-center rounded-full text-white bg-red-600 py-1 text-xs"
                                >
                                    No
                                </p>
                            </td>

                            <td>
                                <button
                                    @click="deleteVideo(value.id)"
                                    type="button"
                                    class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full"
                                >
                                    Delete
                                </button>
                            </td>
                            <td>
                                <button
                                    @click="goToEditPage(value.id)"
                                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Dashboard>
</template>
<script>
import Dashboard from "@/components/Dashboard.vue";
import { mapGetters, mapMutations, mapActions } from "vuex";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

export default {
    name: "videoUpdate",
    components: {
        Dashboard,
    },
    data() {
        return {
            data: [],
        };
    },
    mounted() {
        this.fetchData();
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),
        async fetchData() {
            try {
                const response = await axios.get("/api/video/update");
                console.log(response.data);
                if (response.data.success == true) {
                    this.data = response.data.video;
                } else {
                    console.log("error" + response);
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        async deleteVideo(id) {
            const result = await Swal.fire({
                title: "Are you sure you want to delete?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                customClass: {
                    popup: "confirmDeleteContainer",
                    title: "fonfirm_delete_title",
                    confirmButton: "confirm_delete_button",
                    cancelButton: "confirm_cancel_button",
                },
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.delete(
                        `/api/video/delete/${id}`
                    );
                    console.log(response.data);
                    if (response.data.success) {
                        // this.showNotification(response.data.message);
                        this.fetchData();
                    } else {
                        console.error("Failed to delete");
                    }
                } catch (error) {
                    console.error("Error deleting:", error);
                }
            }
        },
        goToEditPage(id) {
            this.$router.push({
                name: "editVideo",
                params: { id: id },
            });
        },
    },
};
</script>
