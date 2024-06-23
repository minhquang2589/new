<template>
    <Dashboard page-title="Discount - Edit">
        <form class="max-w-md mx-auto" @submit.prevent="discountEdit">
            <div class="relative z-0 w-full mb-5 mt-4 group">
                <input
                    type="number"
                    name="discount"
                    v-model="discount"
                    placeholder="Discount"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                />
                <input
                    type="number"
                    name="quantity"
                    placeholder="Quantity"
                    min="1"
                    max="100"
                    v-model="quantity"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                />
                <input
                    type="number"
                    name="remaining"
                    placeholder="remaining"
                    min="0"
                    v-model="remaining"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                />
            </div>
            <div class="mt-2">
                <label for="start_datetime" class="text-sm">Start day:</label>
                <input
                    type="datetime-local"
                    class="text-sm"
                    name="start_datetime"
                    v-model="start_datetime"
                />
                <br />
                <label for="end_datetime" class="text-sm">End day:</label>
                <input
                    type="datetime-local"
                    id="end_datetime"
                    class="text-sm"
                    name="end_datetime"
                    v-model="end_datetime"
                />
                <br />

                <div class="w-full">
                    <div class="">
                        <select
                            id="status"
                            for="status"
                            name="status"
                            v-model="status"
                            class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option hidden selected disabled>
                                Choose a status
                            </option>
                            <option for="status" value="Active">Active</option>
                            <option for="status" value="Used">Used</option>
                            <option for="status" value="Expired">
                                Expired
                            </option>
                        </select>
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
    name: "EditDiscount",
    components: {
        Dashboard,
    },
    data() {
        return {
            discount: "",
            quantity: "",
            remaining: "",
            status: "",
            start_datetime: null,
            end_datetime: null,
            errorMessages: [],
        };
    },
    mounted() {
        this.getDiscountData();
    },
    computed: {
        ...mapGetters(["notification"]),
    },
    methods: {
        ...mapActions(["showNotification"]),
        async getDiscountData() {
            try {
                const id = this.$route.params.id;
                const response = await axios.get(`/api/discount/edit/${id}`);
                // console.log(response.data);
                if (response.data.success == true) {
                    const discountData = response.data.discount;
                    this.quantity = discountData.quantity;
                    this.discount = discountData.discount;
                    this.remaining = discountData.remaining;
                    this.start_datetime = discountData.start_datetime;
                    this.end_datetime = discountData.end_datetime;
                    this.status = discountData.status;
                } else {
                    console.log("discount edit error.");
                }
            } catch (error) {
                console.error("Error fetching discount data:", error);
            }
        },
        async discountEdit() {
            try {
                const discountId = this.$route.params.id;
                const response = await axios.post("/api/discount/update", {
                    discount: this.discount,
                    start_datetime: this.start_datetime,
                    end_datetime: this.end_datetime,
                    quantity: this.quantity,
                    remaining: this.remaining,
                    status: this.status,
                    id: discountId,
                });
                // console.log(response.data);
                if (response.data.success == true) {
                    this.showNotification(response.data.message);
                    this.getDiscountData();
                } else {
                    this.errorMessages = response.data.error;
                }
            } catch (error) {
                console.error("Error updating discount:", error);
            }
        },
    },
};
</script>
