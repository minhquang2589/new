<template>
    <Dashboard page-title="Order Managements">
        <div class="mx-6 lg:mx-0">
            <div
                class="grid grid-cols-1 mx-4 gap-3 lg:gap-5 lg:mx-10 lg:grid-cols-2"
            >
                <div class="flex justify-center mt-20">
                    <div
                        class="overflow-x-auto bg-gray-100 w-full rounded-lg border"
                    >
                        <div
                            class="flow-root rounded-lg border border-gray-100 py-3"
                        >
                            <div class="flex justify-between mx-10 my-3">
                                <div class="text-gray-800">
                                    <strong>Customer Detail</strong>
                                </div>
                            </div>
                            <div
                                class="flex justify-end border-t border-gray-600"
                            ></div>
                            <div class="divide-y divide-gray-100 text-sm my-8">
                                <div
                                    v-if="dataCustomers.length > 0"
                                    v-for="value in dataCustomers"
                                    :key="value.id"
                                    class="px-8"
                                >
                                    <div>
                                        <div class="text-[12px]">
                                            Status:
                                            <strong class="text-red-700">{{
                                                value.status
                                            }}</strong>
                                        </div>
                                        <div class="lg:flex lg:justify-between">
                                            <div class="text-[12px]">
                                                Name:
                                                <strong
                                                    >{{ value.customer_name }}
                                                    -
                                                    <strong>{{
                                                        value.total_purchases
                                                    }}</strong></strong
                                                >
                                            </div>
                                            <div class="text-[12px]">
                                                Date:
                                                <strong>{{
                                                    value.order_date
                                                }}</strong>
                                            </div>
                                        </div>
                                        <div class="text-[12px]">
                                            Phone:
                                            <strong>{{ value.phone }}</strong>
                                        </div>
                                        <div class="text-[12px]">
                                            Email:
                                            <strong>{{ value.email }}</strong>
                                        </div>
                                        <div class="text-[12px]">
                                            Address:
                                            <strong>{{ value.address }}</strong>
                                        </div>
                                        <div class="text-[12px]">
                                            Order Number:
                                            <strong>{{
                                                value.order_number
                                            }}</strong>
                                        </div>
                                        <div class="text-[12px]">
                                            Payment:
                                            <strong>{{
                                                value.payment_method
                                            }}</strong>
                                        </div>

                                        <div class="text-[12px]">
                                            Total:
                                            <strong>{{formatCurrency( value.total_amount)}}</strong>
                                        </div>

                                        <div v-if="value.voucher_value > 0" class="text-[12px]">
                                            Voucher:
                                            <strong>-{{value.voucher_value}}%</strong>
                                        </div>
                                        <div class="text-[12px]">
                                            Total Discount:
                                            <strong>{{formatCurrency(value.total_discount)}}</strong>
                                        </div>
                                    </div>
                                    <div
                                        class="flex justify-end border-t border-gray-600"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center lg:mt-20">
                    <div
                        class="overflow-x-auto bg-gray-100 w-full rounded-lg border"
                    >
                        <div
                            class="flow-root rounded-lg border border-gray-100 py-3"
                        >
                            <div class="flex mx-10 my-3 justify-between">
                                <div class="text-gray-800">
                                    <strong>Order items</strong>
                                </div>
                                <div class="text-gray-800">
                                    <strong>Item price</strong>
                                </div>
                            </div>
                            <div
                                class="flex justify-end border-t border-gray-600"
                            ></div>

                            <div class="divide-gray-100 text-sm">
                                <div
                                    v-if="orderDetails.length > 0"
                                    v-for="item in orderDetails"
                                    :key="item.id"
                                    class="flex justify-between px-8"
                                >
                                    <div>
                                        <span class="text-[12px]"
                                            >{{ item.product_name }} -
                                            {{ item.size }} x
                                            {{ item.quantity }}</span
                                        >
                                        <div class="text-[12px]">
                                            Color: {{ item.color }}
                                        </div>

                                        <div v-if="item.discount > 0" class="text-[12px]">
                                            discount: -{{item.discount}}%
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="text-[12px]">{{ formatCurrency(item.order_item_price) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-4 my-4">
                            <button
                                type="submit"
                                class="inline-block w-full rounded-lg bg-black px-10 py-2 font-medium text-white sm:w-2/6"
                            >
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
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
    name: "OrderDetails",
    components: {
        Dashboard,
    },
    data() {
        return {
            orderDetails: [],
            dataCustomers: [],
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
                const response = await axios.get(
                    `/api/orderdetail/${this.$route.params.id}`
                );
               //  console.log(response.data);
                if (response.data.success == true) {
                    this.orderDetails = response.data.orderDetails.orderItems;
                    this.dataCustomers =
                        response.data.orderDetails.datacustomer;
                } else {
                    console.log("voucher edit error.");
                }
            } catch (error) {
                console.error(error);
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
    },
};
</script>
