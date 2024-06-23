<template>
    <div class="flex items-center justify-between bg-black">
        <div>
            <router-link to="/dashboard">
                <span
                    class="ml-3 text-white text-sm hover:underline hover:cursor-pointer"
                    >{{ userData.name }}
                </span>
            </router-link>
        </div>
        <div class="text-white text-sm">
            <div class="flex">
                <div class="ml-2">
                    <span class="hover:underline hover:cursor-pointer">
                        <p @click="goToProductEditPage">
                            {{ pageTitle }}
                        </p>
                    </span>
                </div>
            </div>
        </div>
        <div class="text-white mt-1 text-sm mr-3">
            <span class="hover:underline hover:cursor-pointer">
                <p @click="logout">Logout</p>
            </span>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "AdminHeader",
    computed: {
        id() {
            return this.$route.params.id;
        },
        pageTitle() {
            switch (this.$route.name) {
                case "EditProduct":
                    return `Edit product ${this.id}`;
                default:
                    if (this.$route.name == "ViewProduct") {
                        return "Edit product";
                    }
            }
        },
        ...mapGetters(["userData"]),
    },
    methods: {
        ...mapActions(["fetchUser"]),
        goToProductEditPage() {
            const id = this.id;
            this.$router.push({
                name: "EditProduct",
                params: { id: id },
            });
        },
        logout() {
            axios
                .post("/api/logout")
                .then((response) => {
                    if (response.data.success) {
                        this.fetchUser();
                        this.$router.push({ name: "Login" });
                    }
                })
                .catch((error) => {
                    console.error("An error occurred during logout:", error);
                });
        },
    },
};
</script>
