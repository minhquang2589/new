<template>
    <div
        class="flex h-screen w-8/12 fixed z-50 flex-col justify-between bg-white"
    >
        <div class="px-4 py-6">
            <button @click="closeSidebar" class="togger-hidden-siderbar">
                &times;
            </button>
            <ul class="space-y-1 mt-5">
                <li>
                    <router-link to="/shop/item">
                        <a
                            href=""
                            class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium"
                        >
                            Items
                        </a>
                    </router-link>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Products </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/product/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/product/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Size chart </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/sizechart/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/sizechart/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Slider bag </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/slider/bag/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/slider/bag/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Video </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/video/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/video/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Vouchers </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/vouchers/upload">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/vouchers/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Shop </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/shop/upload">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/shop/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Contact </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/contact/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/contact/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Blog </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/blog/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/blog/update">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Section </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/section/upload">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/section/update">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Slider </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/slider/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/slider/update">
                                    <a
                                        href="/slider"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <router-link to="/discount/update">
                        <a
                            href=""
                            class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium"
                        >
                            Discounts
                        </a>
                    </router-link>
                </li>
                <li>
                    <router-link to="/customers">
                        <a
                            href=""
                            class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium"
                        >
                            Customers
                        </a>
                    </router-link>
                </li>
                <li>
                    <router-link to="/orders">
                        <a
                            href=""
                            class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium"
                        >
                            Order Managements
                        </a>
                    </router-link>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium"> Account </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/account/users">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        User
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">About </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/about/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/about/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black"
                        >
                            <span class="text-sm font-medium">Lookbooks </span>
                            <span
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </summary>
                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <router-link to="/lookbook/upload">
                                    <a
                                        href=""
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Upload
                                    </a>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/lookbook/update">
                                    <a
                                        href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black"
                                    >
                                        Update
                                    </a>
                                </router-link>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: "AdminSiderbar",
    props: {
        toggleSidebar: {
            type: Function,
            required: true,
        },
    },
    methods: {
        closeSidebar() {
            this.toggleSidebar();
        },
    },
};
</script>
<style>
.overlay-siderbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 8888 !important;
    transition: opacity 0.5s ease;
    opacity: 1;
}
.siderbar-view {
    position: fixed;
    top: 0;
    left: -370px;
    bottom: 0;
    width: 370px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    z-index: 9999 !important;
    transition: left 0.5s ease;
}

.siderbar-open {
    left: 0;
}
.togger-hidden-siderbar {
    font-size: 23px;
    cursor: pointer;
    z-index: 9999 !important;
    cursor: pointer;
    color: black;
    margin-right: 10px;
}

@media screen and (max-width: 1000px) {
    .siderbar-view {
        width: 330px;
    }
}

@media only screen and (max-width: 768px) {
    .siderbar-view {
        width: 300px;
    }
}
</style>
