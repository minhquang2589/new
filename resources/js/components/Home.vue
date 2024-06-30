<template>
    <Foryou />
    <Section />
    <SliderBag />
    <SliderSale v-if="$route.meta.showSliderSale" />
    <SliderRecently />
    <Product />
</template>

<script>
import Product from "@/components/product/Product.vue";
import SliderRecently from "../components/slider/Recently.vue";
import Shop from "../components/shop/Shop.vue";
import SliderSale from "@/components/slider/SliderSale.vue";
import SliderBag from "../components/sliderbag/SliderBag.vue";
import Section from "@/components/section/Section.vue";
import Foryou from "./slider/Foryou.vue";

export default {
    name: "Home",
    components: {
        Product,
        SliderRecently,
        Shop,
        SliderSale,
        SliderBag,
        Section,
        Foryou,
    },
};
</script>
