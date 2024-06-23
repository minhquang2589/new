<template>
    <Dashboard page-title="Users">
        <div class="mx-6 w-fit lg:mx-0">
            <div class="flex justify-center">
                <table
                    class="lg:w-fit w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm"
                >
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Name
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Phone
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Email
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Role
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Birthday
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-2 font-medium text-gray-900"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        v-for="value in dataUsers"
                        :key="value.id"
                        class="divide-y divide-gray-200"
                    >
                        <tr>
                            <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.name }}
                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.phone }}
                            </td>
                              <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.email }}
                            </td>
                              <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.role }}
                            </td>
                              <td
                                class="whitespace-nowrap px-4 py-2 text-gray-900"
                            >
                                {{ value.birthday }}
                            </td>
                            <td>
                                <button
                                    @click="deleteUser(value.id)"
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
    name: "Users",
    components: {
        Dashboard,
    },
    data() {
        return {
            dataUsers: [],
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
                const response = await axios.get("/api/users/view");
               //  console.log(response.data);
                if (response.data.success == true) {
                    this.dataUsers = response.data.users;
                } else {
                    console.log("error" + response);
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        async deleteUser(userId) {
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
                        `/api/user/delete/${userId}`
                    );
                    console.log(response);
                    if (response.data.success) {
                        this.showNotification(response.data.message);
                        this.fetchData();
                    } else {
                        console.error("Failed to delete voucher");
                    }
                } catch (error) {
                    console.error("Error deleting voucher:", error);
                }
            }
        },
        goToEditPage(voucherId) {
            this.$router.push({
                name: "editUser",
                params: { id: voucherId },
            });
        },
    },
};
</script>
