<template>
    <a
        class="messageBtn"
        target="_blank"
        href="https://www.facebook.com/messages/t/100014302507421"
    >
        <svg
            class="svgMessage"
            viewBox="0 0 39 39"
            xmlns="http://www.w3.org/2000/svg"
            fill-rule="evenodd"
            clip-rule="evenodd"
        >
            <path
                d="M12 0c-6.627 0-12 4.975-12 11.111 0 3.497 1.745 6.616 4.472 8.652v4.237l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111 0-6.136-5.373-11.111-12-11.111zm1.193 14.963l-3.056-3.259-5.963 3.259 6.559-6.963 3.13 3.259 5.889-3.259-6.559 6.963z"
            />
        </svg>
    </a>

    <button @click="toggleSidebar" class="sidebar-toggle z-40">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div
        v-show="isSidebarOpen"
        class="overlay-siderbar block lg:hidden"
        @click="toggleSidebar"
    ></div>
    <div
        :class="{ 'siderbar-open': isSidebarOpen }"
        class="siderbar-view block lg:hidden"
    >
        <div v-if="isAdmin">
            <AdminSiderbar :toggleSidebar="toggleSidebar" />
        </div>
        <div v-else>
            <Siderbar :toggleSidebar="toggleSidebar" />
        </div>
    </div>
    <router-view></router-view>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import { ref, provide } from "vue";
import Header from "@/components/Header.vue";
import Siderbar from "@/components/layout/Siderbar.vue";
import AdminSiderbar from "@/components/admin/AdminSiderbar.vue";

export default {
    name: "App",
    components: {
        Header,
        AdminSiderbar,
        Siderbar,
    },
    data() {
        return {
            isSidebarOpen: false,
        };
    },
    computed: {
        ...mapGetters(["isAdmin"]),
    },
    methods: {
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
    },
    created() {
        this.$store.dispatch("fetchUser");
    },
};
</script>
<style>
.messageBtn {
    position: fixed;
    z-index: 10 !important;
    right: 0;
    bottom: 0;
}

.svgMessage {
    width: 90px;
    height: 120px;
    overflow: hidden;
}
@media only screen (max-width: 768px) {
    .svgMessage {
        width: 70px;
        height: 100px;
    }
}
</style>
