<template>
    <div class="lg:flex">
        <div class="lg:w-1/2 xl:max-w-screen-sm">
            <div
                class="py-12 lg:bg-white flex justify-center lg:justify-start lg:px-12"
            ></div>
            <div
                class="mt-10 px-6 sm:px-24 md:px-48 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl"
            >
                <h2
                    class="text-center flex justify-center text-4xl text-gray-800 font-display font-semibold lg:text-left xl:text-4xl xl:text-bold"
                >
                    Log in
                </h2>
                <div class="flex mt-3 justify-center">
                    <ul class="flex text-sm text-gray-800">
                        <router-link to="/">
                            <li><a class="hover:underline" href="">Home</a></li>
                        </router-link>

                        <li class="px-2">/</li>
                        <router-link to="/register">
                            <li>
                                <a class="hover:underline" href="">Register</a>
                            </li>
                        </router-link>
                    </ul>
                </div>
                <div class="mt-12 bg-white shadow-md px-5 pt-6 pb-8 mb-4">
                    <form @submit.prevent="login">
                        <div>
                            <input
                                type="email"
                                v-model="email"
                                placeholder="Enter your email"
                                class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                            />

                            <input
                                type="password"
                                v-model="password"
                                placeholder="Enter your password"
                                class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                            />
                        </div>
                        <div
                            v-if="errorMessages.length"
                            class="error-messages mt-1 text-xs text-red-600"
                        >
                            <ul>
                                <li
                                    v-for="(error, index) in errorMessages"
                                    :key="index"
                                >
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <div class="mt-6">
                            <LoadingButton
                                class="bg-gray-700 text-gray-100 p-4 w-full rounded-full tracking-wide font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-gray-800 shadow-lg"
                                :loading="isLoadingButton"
                            >
                                <button type="submit">Log In</button>
                            </LoadingButton>
                        </div>
                    </form>
                    <div
                        class="mt-12 text-sm font-display font-semibold text-gray-700 text-center"
                    >
                        Don't have an account ?
                        <router-link to="/register">
                            <a
                                href="#"
                                class="cursor-pointer text-red-600 hover:text-red-800"
                                >Sign up</a
                            >
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="hidden w-full h-2/5 lg:flex items-center justify-center flex-1"
        >
            <div
                class="z-1 transform duration-200 hover:scale-110 cursor-pointer"
            >
                <img
                    class="w-full mx-auto"
                    xmlns=""
                    id="f080dbb7-9b2b-439b-a118-60b91c514f72"
                    data-name="Layer 1"
                    viewBox="0 0 528.71721 699.76785"
                    src="https://tailwindcss.com/_next/static/media/installation.50c59fdd.jpg"
                    alt="image"
                />
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { mapGetters, mapMutations, mapActions } from "vuex";
import LoadingButton from "../components/layout/LoadingButton.vue";

export default {
    name: "Login",
    components: { LoadingButton },
    data() {
        return {
            email: "",
            password: "",
            errorMessages: [],
            isLoadingButton: false,
        };
    },
    methods: {
        ...mapActions(["fetchUser"]),
        login() {
            this.isLoadingButton = true;
            this.errorMessages = [];
            axios
                .post("/api/login", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    // console.log(response.data);
                    if (response.data.success) {
                        if (response.data.role === "admin") {
                            this.fetchUser();
                            this.isLoadingButton = false;
                            this.$router.push({ name: "Dashboard" });
                        } else {
                            this.isLoadingButton = false;
                            this.$router.push({ name: "Home" });
                        }
                    } else {
                        this.errorMessages = response.data.errors;
                        this.isLoadingButton = false;
                    }
                })
                .catch((error) => {
                    this.errorMessages = [
                        "An error occurred while logging in.",
                    ];
                    this.isLoadingButton = false;
                });
        },
    },
};
</script>
