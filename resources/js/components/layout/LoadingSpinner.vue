<template>
    <div class="loading-screen" v-if="isLoading">
        <div class="spinner"></div>
    </div>
</template>

<script>
export default {
    name: "LoadingSpinner",
    props: {
        isLoading: {
            type: Boolean,
            required: true,
        },
    },
};
</script>

<style scoped>
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999 !important;
    pointer-events: all !important;
}

.spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid black;
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 0.5s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
