<template>
    <div v-if="$route.meta.showSlider && dataSlider != null" class="swiper-container swiper">
        <div class="slider_1">
            <div class="swiper_1 mySwiper_1">
                <div class="swiper-wrapper">
                    <div
                        v-for="value in dataSlider"
                        :key="value.id"
                        @click="navigateToUrl(value.link_url)"
                        class="swiper-slide swiper-image hover:cursor-pointer"
                    >
                        <img
                            :src="`/images/${value.image}`"
                            :alt="value.image"
                        />
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="autoplay-progress">
                    <svg style="display: none"></svg>
                    <span style="display: none"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Slider",
    data() {
        return {
            dataSlider: [],
            progressCircle: null,
            progressContent: null,
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        navigateToUrl(url) {
            if (url) {
                window.location.href = url;
            }
        },
        fetchData() {
            axios
                .get("/api/slider")
                .then((response) => {
                    // console.log(response.data);
                    this.dataSlider = response.data.slider;
                    this.$nextTick(() => {
                        this.initSwiper();
                    });
                })
                .catch((error) => {
                    console.error("Lỗi:", error);
                });
        },
        initSwiper() {
            this.progressCircle = document.querySelector(
                ".autoplay-progress svg"
            );
            this.progressContent = document.querySelector(
                ".autoplay-progress span"
            );

            var swiper1 = new Swiper(".mySwiper_1", {
                spaceBetween: 5,
                centeredSlides: true,
                autoplay: {
                    delay: 1300,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        },
    },
};
</script>

<style scoped>
.slider_1 {
    position: relative;
    height: 100%;
    margin: 0px 10px 0px 10px;
}

.slider_1 {
    height: 500px;
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #fff;
    margin: 0;
    padding: 0;
}

@media screen and (max-width: 720px) {
    .slider_1 {
        height: 290px;
        margin: 0px 5px 0px 5px;
    }
}

@media screen and (max-width: 1000px) {
    .slider_1 {
        height: 350px;
        margin: 0px 5px 0px 5px;
    }
}

.swiper_1 {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    height: 100%;
    object-fit: cover;
}

.swiper-image {
    height: 100%;
}
.swiper {
    z-index: 1;
}
</style>
