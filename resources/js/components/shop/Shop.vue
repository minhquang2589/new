<template>
    <div
        v-if="shop && shop.image != null"
        @click="navigateToUrl(shop.link_url)"
        class="w-full h-full"
    >
        <img :src="`/images/${shop.image}`" />
    </div>
</template>
<script>
export default {
    name: "Shop",
    data() {
        return {
            shop: {},
        };
    },
    mounted() {
        axios
            .get("/api/shop/image")
            .then((response) => {
                // console.log(response.data);
                if (response.data.success == true) {
                    this.shop = response.data.shop;
                } else {
                    this.shop = null;
                }
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
    methods: {
        navigateToUrl(url) {
            if (url) {
                window.location.href = url;
            } else {
                this.router.push({ name: "Home" });
            }
        },
    },
};
</script>
