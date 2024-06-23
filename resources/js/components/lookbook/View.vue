<template>
    <div v-if="lookbook != null">
        <div class="p-4 text-center sm:p-6 lg:p-8">
            <h2 class="mt-6 font-black uppercase">
                <span class="text-4xl font-black sm:text-5xl lg:text-6xl">
                    {{ lookbook.title }}
                </span>
                <p class="mt-8 text-xs font-medium uppercase text-gray-400">
                    {{ lookbook.description }}
                </p>
            </h2>
        </div>
        <div v-html="lookbook.content"></div>
    </div>
    <LoadingSpinner :isLoading="isLoading" />
</template>
<script>
import LoadingSpinner from "../layout/LoadingSpinner.vue";

export default {
    name: "viewLookbook",
    components: {
        LoadingSpinner,
    },
    props: ["id"],
    data() {
        return {
            lookbook: null,
            isLoading: true,

        };
    },
    mounted() {
        this.fetchData(this.id);
    },
    watch: {
        id(newId) {
            this.fetchData(newId);
        },
    },
    methods: {
        async fetchData(id) {
           this.isLoading = true;
            try {
                const response = await axios.get(`/api/lookbook-view/${id}`);
               //  console.log(response.data);
                if (response.data.success == true) {
                   this.isLoading = false;
                    this.lookbook = response.data.lookbook;
                } else {
                   this.isLoading = true;
                    this.lookbook = null;
                }
            } catch (error) {
                this.isLoading = true;
                console.error("Error fetching data:", error);
            }
        },
    },
};
</script>
