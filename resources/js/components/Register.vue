<template>
    <div class="lg:flex">
        <div class="lg:w-1/2 xl:max-w-screen-sm">
            <div
                class="sm:px-24 px-5 mt-0 md:px-48 pt-10 lg:px-12 lg:mt-6 xl:px-24"
            >
                <h2
                    class="text-center flex justify-center text-4xl font-display font-semibold xl:text-4xl xl:text-bold"
                >
                    Register
                </h2>
                <div class="flex mt-3 justify-center">
                    <ul class="flex text-sm text-gray-800">
                        <router-link to="/">
                            <li><a class="hover:underline" href="">Home</a></li>
                        </router-link>

                        <li class="px-2">/</li>
                        <router-link to="/login">
                            <li>
                                <a class="hover:underline" href="">Login</a>
                            </li>
                        </router-link>
                    </ul>
                </div>
                <div class="mt-12">
                    <form @submit.prevent="register">
                        <div
                            class="bg-white shadow-md rounded px-8 pt-6 pb-8 flex flex-col my-2"
                        >
                            <div class="-mx-3">
                                <div class="md:w-full px-3">
                                    <input
                                        type="text"
                                        name="fullname"
                                        id="fullname"
                                        v-model="fullname"
                                        class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                        placeholder="Full Name"
                                    />
                                    <input
                                        v-model="email"
                                        name="email"
                                        type="text"
                                        class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                        placeholder=" Email Address"
                                    />
                                    <input
                                        id="phone"
                                        name="phone"
                                        type="tphoneext"
                                        placeholder="Enter Your Phone Number"
                                        v-model="phone"
                                        class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                    />
                                    <input
                                        id="address"
                                        name="address"
                                        type="text"
                                        placeholder="Enter Your Address"
                                        v-model="address"
                                        class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                    />
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <input
                                    class="appearance-none mr-1 border-gray-400 block w-full bg-grey-lighter text-sm text-grey-darker border border-grey-lighter rounded py-2 px-6 sm:px-8 lg:px-8 mb-3"
                                    id="birthday"
                                    name="birthday"
                                    type="date"
                                    placeholder="Enter Your Phone Number"
                                    v-model="birthday"
                                />
                                <select
                                    id="gender"
                                    for="gender"
                                    name="gender"
                                    v-model="gender"
                                    class="appearance-none border-gray-400 block w-full bg-grey-lighter text-sm text-grey-darker border border-grey-lighter rounded py-2 px-6 sm:px-8 lg:px-8 mb-3"
                                >
                                    <option hidden selected disabled>
                                        Choose a gender
                                    </option>
                                    <option for="gender" value="Male">
                                        Male
                                    </option>
                                    <option for="gender" value="Female">
                                        Female
                                    </option>
                                </select>
                            </div>
                            <div class="inline-table">
                                <div class="-mx-3 mb-3">
                                    <div class="md:w-full px-3">
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            placeholder="Password"
                                            v-model="password"
                                            class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                        />
                                        <input
                                            id="confirm_password"
                                            name="confirm_password"
                                            type="password"
                                            placeholder="Confirm password"
                                            v-model="confirm_password"
                                            class="text-sm border border-gray-400 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                                        />
                                        <p class="text-gray-600 text-xs italic">
                                            Make it as long and as crazy as
                                            you'd like
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-if="errorMessages.length"
                                class="error-messages mt-1 text-xs text-red-600"
                            >
                                <ul>
                                    <li
                                        class="mt-2"
                                        v-for="(error, index) in errorMessages"
                                        :key="index"
                                    >
                                        {{ error }}
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10">
                                <button
                                    class="bg-gray-700 text-gray-100 p-4 w-full rounded-full tracking-wide font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-gray-800 shadow-lg"
                                >
                                    Register
                                </button>
                            </div>
                            <div
                                class="mt-12 text-sm font-display font-semibold text-gray-700 text-center"
                            >
                                You have account?
                                <router-link to="/login">
                                    <a
                                        href="#"
                                        class="cursor-pointer text-red-600 hover:text-red-800"
                                        >Sign in</a
                                    >
                                </router-link>
                            </div>
                        </div>
                    </form>
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
export default {
    name: "Register",
    data() {
        return {
            fullname: "",
            email: "",
            phone: "",
            birthday: "",
            gender: "",
            password: "",
            confirm_password: "",
            address: "",
            errorMessages: [],
        };
    },
    methods: {
        register() {
            axios
                .post("/api/register", {
                    fullname: this.fullname,
                    email: this.email,
                    phone: this.phone,
                    birthday: this.birthday,
                    gender: this.gender,
                    password: this.password,
                    confirm_password: this.confirm_password,
                    address: this.address,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.$router.push({ name: "Home" });
                    } else if (response.data.existingUser) {
                        this.email = response.data.existingUser.email;
                        this.errorMessages = response.data.existingUser.message;
                    } else {
                        this.errorMessages = response.data.errors;
                    }
                })
                .catch((error) => {
                    this.errorMessages = [
                        "An error occurred while registering: " + error,
                    ];
                });
        },
    },
};
</script>
