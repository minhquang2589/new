<template>
    <div class="loading-button" :class="{ btnLoading: loading }">
        <div v-if="loading" class="spinnerButton"></div>
        <div><slot></slot></div>
    </div>
</template>

<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style scoped>
.loading-button {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px !important;
    position: relative;
    cursor: pointer;
}

.btnLoading {
    opacity: 0.6;
    pointer-events: none;
    cursor: not-allowed;
}

.spinnerButton {
    position: absolute;
    border: 3px solid #f3f3f3;
    border-top: 3px solid black;
    border-radius: 50%;
    width: 27px;
    height: 27px;
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
