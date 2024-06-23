<template>
    <div class="mt-5 mb-2 flex justify-center">
        <div>
            <h1 class="lg:text-xl text-sm font-bold text-gray-900 sm:text-3xl">
                Video
            </h1>
        </div>
    </div>
    <div
        class="grid mt-3 lg:mt-8 lg:px-10 px-2 grid-cols-1 gap-3 lg:grid-cols-3"
    >
        <div v-for="value in video" :key="value.id" class="rounded-lg">
            <div class="video-container">
                <iframe
                    :src="getVimeoEmbedUrl(value.vimeo_video_url)"
                    frameborder="0"
                    allowfullscreen
                ></iframe>
            </div>
            <div class="flex mt-2 mb-4 justify-center items-center">
                <p class="text-gray-600 text-sm transition hover:opacity-75">
                {{value.title}}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Video",
    data() {
        return {
            video: [],
        };
    },
    mounted() {
        axios
            .get("/api/video")
            .then((response) => {
                console.log(response.data);
                if (response.data.success == true) {
                    this.video = response.data.video;
                }
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
    methods: {
        getVimeoEmbedUrl(videoUrl) {
            const videoId = this.extractVimeoId(videoUrl);
            return `https://player.vimeo.com/video/${videoId}`;
        },
        extractVimeoId(url) {
            const regex = /vimeo\.com\/(\d+)/;
            const match = url.match(regex);
            return match ? match[1] : "";
        },
    },
};
</script>
<style>
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    max-width: 100%;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
