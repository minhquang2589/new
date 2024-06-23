<template>
    <div
        class="modal-sizechart"
        :class="{ show: showModalSize }"
        @click.self="closeModalSize"
    >
        <div class="modal-sizechart-content">
            <div class="flex justify-end">
                <button class="close-modal-button" @click="closeModalSize">
                    &times;
                </button>
            </div>
            <img
                class="image-detail"
                :src="getImageByCategory(categoryProp)"
                alt="size chart"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "sizeChart",
    props: {
        showModalSize: {
            type: Boolean,
            required: true,
        },
        categoryProp: String,
    },
    data() {
        return {
            dataCate: [],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        closeModalSize() {
            this.$emit("closeModalSize");
        },
        async fetchData() {
            try {
                const response = await axios.get(`/api/size/view`);
                // console.log(response.data);
                if (response.data.success == true) {
                    this.dataCate = response.data.sizechart;
                } else {
                    this.dataCate = [];
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        getImageByCategory(category) {
            const foundItem = this.dataCate.find(
                (item) => item.cate_name === category
            );
            if (foundItem) {
                return `/images/${foundItem.image_url}`;
            } else {
                return "";
            }
        },
    },
};
</script>
<style>
.modal-sizechart {
    transition: opacity 0.5s ease, visibility 0.3s ease;
    opacity: 0;
    visibility: hidden;
    position: fixed;
    z-index: 9999 !important;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    backdrop-filter: blur(3px);
    background-color: rgba(0, 0, 0, 0.6);
}

.modal-sizechart.show {
    opacity: 1;
    visibility: visible;
}

.modal-sizechart-content {
    background-color: #fff;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px;
    border: 1px solid gray;
    width: 95%;
    max-width: 60%;
    max-height: 80%;
    overflow-y: auto;
    border-radius: 10px;
}
.close-modal-button {
    font-size: 26px;
    cursor: pointer;
    z-index: 9999 !important;
    padding-right: 5px;
    padding-left: 5px;
    color: black;
}

.image-detail {
    text-align: center;
    font-size: 18px;
    display: block;
    width: 90%;
    height: 100%;
    object-fit: cover;
    margin-left: auto;
    margin-right: auto;
}
@media only screen and (max-width: 768px) {
    .modal-sizechart-content {
        max-width: 95%;
        top: 50%;
    }
    .close-modal-button {
        font-size: 23px;
    }
}
</style>
