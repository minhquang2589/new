<template>
    <div id="main_content">
        <Header v-if="!$route.meta.hideHeader" />
        <Shop v-if="$route.meta.showShop" />
        <!-- <discountSection v-if="$route.meta.showDiscountSection" /> -->
        <!-- <Section v-if="$route.meta.showSection" /> -->
        <Slider v-if="$route.meta.showSlider" />
        <main>
            <router-view />
        </main>
        <Footer v-if="!$route.meta.hideFooter" />
        
    </div>
</template>

<script>
import Header from "@/components/Header.vue";
import Footer from "@/components/footer/Footer.vue";
import Section from "@/components/section/Section.vue";
import Slider from "@/components/slider/Slider.vue";
import SliderSale from "@/components/slider/SliderSale.vue";
import Product from "@/components/product/Product.vue";
import Shop from "@/components/shop/Shop.vue";
import discountSection from "../components/section/discountSection.vue";

export default {
    components: {
        Header,
        Footer,
        Section,
        SliderSale,
        Slider,
        Product,
        Shop,
        discountSection,
    },
};
</script>
