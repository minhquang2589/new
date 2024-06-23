<template>
    <div
        class="grid mt-10 lg:h-screen grid-cols-1 lg:px-10 px-1 gap-4 lg:grid-cols-2 lg:gap-8"
    >
        <div class="rounded-lg">
            <div
                class="z-1 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32"
            >
                <div
                    class="mt-10 lg:flex lg:justify-center lg:items-center mx-auto max-w-9xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28"
                >
                    <div class="sm:text-center lg:text-left">
                        <div class="w-full lg:col-span-1">
                            <div v-html="contactData.content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div id="map"></div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Contact",
    data() {
        return {
            title: "",
            image_url: "",
            description: "",
            content: "",
            title: "",
            map: null,
            marker: null,
            contactData: {},
            storeLocation: { lat: 21.02856, lng: 105.77832 },
        };
    },
    mounted() {
        this.getContactData();
        const apiKey = "AIzaSyB_U8tS5Jqi4RlBkMwGSH1ir7B6xU-wPnQ";
        const script = document.createElement("script");
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onload = this.initMap;
        document.head.appendChild(script);

        axios
            .get("/api/blog")
            .then((response) => {
                // console.log(response.data);
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
    methods: {
        async getContactData() {
            try {
                const response = await axios.get(`/api/contact-info`);
                // console.log(response.data);
                if (response.data.success == true) {
                    this.contactData = response.data.data;
                }
            } catch (error) {
                console.error("Error:", error);
            }
        },
        initMap() {
            this.map = new google.maps.Map(document.getElementById("map"), {
                center: this.storeLocation,
                zoom: 15,
            });
            this.marker = new google.maps.Marker({
                position: this.storeLocation,
                map: this.map,
                title: "Minh Quang Store",
            });
        },
    },
};
</script>

<style>
#map {
    height: 75%;
    width: 100%;
}
@media only screen and (max-width: 768px) {
    #map {
        height: 400px;
        width: 420px;
    }
}
</style>
