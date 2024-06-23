<template>
    <transition name="overlay">
        <div v-if="show" class="overlay-search" @click="closeSearch">
            <transition name="slide">
                <div class="search-container rounded-lg" @click.stop>
                    <div class="flex justify-start mb-4 ml-3">
                        <button @click="closeSearch" class="search-button">
                            &times;
                        </button>
                    </div>
                    <div class="flex">
                        <input
                            class="border rounded-lg border-gray-500 mr-2"
                            v-model="query"
                            placeholder="Search for products..."
                        />
                        <button @click="executeSearch" class="mb-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            query: "",
        };
    },
    methods: {
        executeSearch() {
            if (this.query !== "") {
                this.$emit("close");
                this.$router.push({
                    name: "SearchResults",
                    query: { query: this.query },
                });
            }
        },
        closeSearch() {
            this.$emit("close");
        },
    },
};
</script>

<style scoped>
.overlay-search {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.search-button {
    font-size: 24px;
    cursor: pointer;
    z-index: 9999 !important;
    cursor: pointer;
    color: black;
}

.search-container {
    width: 40%;
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    transform: translateY(0);
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.search-container input {
    padding: 5px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
}

@media only screen and (max-width: 768px) {
    .search-container {
        width: 95%;
    }
}

.overlay-enter-active,
.overlay-leave-active {
    transition: opacity 0.5s ease;
}

.overlay-enter,
.overlay-leave-to {
    opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
    transition: transform 0.5s ease, opacity 0.5s ease;
}

.slide-enter,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
