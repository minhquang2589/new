<template>
    <Dashboard page-title="User - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="userUpdate">
            <div class="-mx-3">
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
                        <option for="gender" value="Male">Male</option>
                        <option for="gender" value="Female">Female</option>
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
                                Make it as long and as crazy as you'd like
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
            </div>
            <div class="mb-5 mt-2 w-full">
                <div class="flex justify-start lg:flex lg:justify-start">
                    <button
                        type="submit"
                        class="text-white mt-6 bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-1/2 sm:w-auto px-20 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
    name: "editUser",
    components: {
        Dashboard,
    },
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
    mounted() {
        this.getUserData();
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),
        async getUserData() {
            try {
                const response = await axios.get(
                    `/api/user/edit/${this.$route.params.id}`
                );
                //  console.log(response.data);
                if (response.data.success == true) {
                    const userData = response.data.user;
                    this.fullname = userData.name;
                    this.email = userData.email;
                    this.phone = userData.phone;
                    this.gender = userData.gender;
                    this.address = userData.address;
                    this.birthday = userData.birthday;
                    this.gender = userData.genders;
                } else {
                    console.log("voucher edit error.");
                }
            } catch (error) {
                console.error("Error fetching voucher data:", error);
            }
        },
        async userUpdate() {
            try {
                const userId = this.$route.params.id;
                const response = await axios.post("/api/user/update", {
                    fullname: this.fullname,
                    email: this.email,
                    phone: this.phone,
                    birthday: this.birthday,
                    gender: this.gender,
                    password: this.password,
                    confirm_password: this.confirm_password,
                    address: this.address,
                    userId: userId,
                });
                //  console.log(response.data);
                if (response.data.success == true) {
                    this.showNotification(response.data.message);
                    this.getUserData();
                } else {
                    this.errorMessages = response.data.error;
                }
            } catch (error) {
                console.error("Error updating voucher:", error);
            }
        },
    },
};
</script>
