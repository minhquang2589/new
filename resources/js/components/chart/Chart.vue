<template>
    <div class="px-2">
        <h2 class="text-xl flex justify-center nt-5 lg:mt-10 font-bold">
            Chart
        </h2>
        <h2 class="text-gray-600 lg:ml-5 py-10">
            total amount the month:
            {{ this.formatCurrency(totalSales) }}.
        </h2>
        <div class="grid grid-cols-1 gap-1 lg:grid-cols-2">
            <div class="rounded-lg">
                <canvas id="monthlySalesChart"></canvas>
            </div>

            <div class="rounded-lg">
                <canvas id="monthlyOrdersChart"></canvas>
            </div>
            <div class="rounded-lg">
                <canvas id="topSellingProductsChart"></canvas>
            </div>
            <div class="rounded-lg">
                <canvas id="topUsers"></canvas>
            </div>
            <div class="rounded-lg">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
    <LoadingSpinner :isLoading="isLoading" />
</template>

<script>
import { Chart, registerables } from "chart.js";
import { mapGetters, mapMutations, mapActions, mapState } from "vuex";
import LoadingSpinner from "../layout/LoadingSpinner.vue";

import axios from "axios";
Chart.register(...registerables);
export default {
    name: "Chart",
    components: {
        LoadingSpinner,
    },
    data() {
        return {
            totalSales: 0,
            topSellingProducts: [],
            monthlySales: [],
            monthlyOrders: [],
            topUsers: [],
            orderStatusData: [],
            isLoading: true,
        };
    },
    mounted() {
        this.fetchData();
    },
    computed: {
        ...mapGetters(["formatCurrency"]),
    },
    methods: {
        async fetchData() {
            this.isLoading = true;
            try {
                const response = await axios.get("/api/monthly-sales");
                // console.log(response.data);
                this.totalSales = response.data.totalSales;
                this.monthlySales = response.data.monthlySales;
                this.monthlyOrders = response.data.monthlyOrderCounts;
                this.topSellingProducts = response.data.topSellingProducts;
                this.topUsers = response.data.topUsers;
                this.orderStatusData = response.data.getOrderStatus;
                this.renderChart();
                this.SellingMonth();
                this.renderChartMonthlyOrders();
                this.renderTopUsers();
                this.renderCharOrderStatus();
                this.isLoading = false;
            } catch (error) {
                console.error("Error:", error);
            }
        },
        viewProduct(event, elements) {
            if (elements.length > 0) {
                const elementIndex = elements[0].index;
                const productId =
                    this.topSellingProducts[elementIndex].product_id;
                this.$router.push({
                    name: "ViewProduct",
                    params: { id: productId },
                });
            }
        },
        renderChart() {
            const ctx = document
                .getElementById("topSellingProductsChart")
                .getContext("2d");
            const labels = this.topSellingProducts.map(
                (product) => `${product.class}: ${product.name}`
            );
            const data = this.topSellingProducts.map(
                (product) => product.total_quantity
            );

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: " Selling qty",
                            data: data,
                            backgroundColor: [
                                "rgba(0, 0, 0, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(255, 205, 86, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                            ],
                        },
                    ],
                },
                options: {
                    onClick: this.viewProduct,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
        SellingMonth() {
            const ctx = document
                .getElementById("monthlySalesChart")
                .getContext("2d");
            const labels = this.monthlySales.map((sale) => sale.month);
            const data = this.monthlySales.map((sale) => sale.total_amount);
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Total revenue",
                            data: data,
                            backgroundColor: "rgba(0, 0, 0, 0.6)",
                            fill: true,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            title: {
                                display: true,
                                text: "Mounth",
                            },
                        },
                    },
                },
            });
        },
        renderChartMonthlyOrders() {
            const ctx = document
                .getElementById("monthlyOrdersChart")
                .getContext("2d");
            const labels = this.monthlyOrders.map((order) => order.month);
            const data = this.monthlyOrders.map((order) => order.total_orders);

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Total number of orders",
                            data: data,
                            backgroundColor: [
                                "rgba(0, 0, 0, 0.6)",
                                "rgba(201, 203, 207, 0.6)",
                            ],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
        renderTopUsers() {
            const ctx = document.getElementById("topUsers").getContext("2d");
            const labels = this.topUsers.map((order) => order.name);
            const data = this.topUsers.map((order) => order.total_orders);

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Total orders",
                            data: data,
                            backgroundColor: [
                                "rgba(0, 0, 0, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(255, 205, 86, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(201, 203, 207, 0.6)",
                            ],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
        renderCharOrderStatus() {
            const ctx = document
                .getElementById("orderStatusChart")
                .getContext("2d");

            const labels = this.orderStatusData.map((value) => value.status);
            const data = this.orderStatusData.map((value) => value.count);
            new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: " Unpaid orders",
                            data: data,
                            backgroundColor: [
                                "rgba(0, 0, 0, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(255, 205, 86, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                            ],
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },
    },
};
</script>
