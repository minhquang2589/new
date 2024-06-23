<template>
    <div class="grid grid-cols-1 pb-16 gap-1 lg:grid-cols-6">
        <div class="h-fit standing">
            <Siderbar />
        </div>
        <div class="h-full lg:col-span-5">
            <h2 class="text-xl flex py-2 px-3 font-bold">{{ pageTitle }}</h2>
            <div v-if="$slots.default" class="px-3 lg:px-0">
                <slot></slot>
            </div>
            <div v-else>
                <Chart />
            </div>
        </div>
    </div>
</template>
<script>
import Siderbar from "@/components/Siderbar.vue";
import Chart from "@/components/chart/Chart.vue";
export default {
    name: "Dashboard",
    components: {
        Siderbar,
        Chart,
    },
    props: {
        pageTitle: {
            type: String,
        },
    },
};
</script>
<style>
.standing {
    max-height: calc(100vh - 100px);
    position: sticky;
    top: 66px;
}
</style>
