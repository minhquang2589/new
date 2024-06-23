<template>
    <div class="w-fit flex justify-center items-center ml-3">
        <Dashboard page-title="Product - Upload">
            <form class="max-w-md mx-auto" @submit.prevent="upload">
                <div class="max-w-lg">
                    <div class="my-5">
                        <div
                            v-if="productImage.length"
                            class="grid gap-1 grid-cols-3"
                        >
                            <div
                                v-for="(item, index) in productImage"
                                :key="index"
                                class="mr-2"
                            >
                                <img
                                    class="size-28"
                                    :src="`${item.image}`"
                                    :alt="`${item.image}`"
                                />
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="triggerFileInput"
                            class="underline mt-4 hover:text-blue-600"
                        >
                            Add images
                        </button>
                        <input
                            ref="fileInput"
                            @change="handleImageUpload"
                            class="hidden"
                            aria-describedby="images"
                            for="images"
                            type="file"
                            id="image-input"
                            name="images[]"
                            multiple
                        />
                    </div>
                </div>
                <div class="relative z-0 mb-5 mt-4 group">
                    <input
                        type="text"
                        name="product_name"
                        id="product_name"
                        v-model="product_name"
                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                        placeholder="Product name"
                    />
                    <input
                        require
                        type="text"
                        name="price"
                        id="price"
                        v-model="price"
                        placeholder="Price"
                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                    />
                </div>

                <div class="mt-4">
                    <div class="w-full mr-5">
                        <div class="">
                            <select
                                id="gender"
                                for="gender"
                                name="gender"
                                v-model="gender"
                                class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option hidden selected disabled>
                                    Choose a gender
                                </option>
                                <option for="gender" value="Men">Men</option>
                                <option for="gender" value="Women">
                                    Women
                                </option>
                                <option for="gender" value="Unisex">
                                    Unisex
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full mr-5">
                        <div class="">
                            <select
                                id="class"
                                for="class"
                                name="class"
                                v-model="class"
                                class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option hidden selected disabled>
                                    Choose a class
                                </option>
                                <option for="class" value="clothes">
                                    clothes
                                </option>
                                <option for="class" value="bag">bag</option>
                                <option for="class" value="hat">hat</option>
                                <option for="class" value="shoe">shoe</option>
                                <option for="class" value="accessory">
                                    accessory
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="start_datetime" class="text-sm"
                        >Start discount:</label
                    >
                    <input
                        type="datetime-local"
                        class="text-sm"
                        v-model="start_datetime"
                        id="start_datetime"
                        name="start_datetime"
                    />
                    <br />
                    <label for="end_datetime" class="text-sm"
                        >End discount:</label
                    >
                    <input
                        type="datetime-local"
                        id="end_datetime"
                        class="text-sm"
                        name="end_datetime"
                        v-model="end_datetime"
                    />
                    <br />
                    <div class="flex my-3">
                        <label
                            for="Username"
                            class="relative mr-1 w-full block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
                        >
                            <input
                                type="number"
                                name="discountnumber"
                                placeholder="Discount %"
                                min="1"
                                max="100"
                                v-model="discountnumber"
                                oninput="validity.valid||(value='');"
                                class="peer border-none w-full py-1 bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0"
                            />
                            <span
                                class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs"
                            >
                                Discount %
                            </span>
                        </label>
                        <label
                            for="Username"
                            class="relative w-full block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
                        >
                            <input
                                type="number"
                                name="discountquantity"
                                placeholder="Discount Quantity"
                                min="0"
                                v-model="discountquantity"
                                oninput="validity.valid||(value='');"
                                class="peer border-none w-full py-1 bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0"
                            />
                            <span
                                class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs"
                            >
                                Discount Quantity
                            </span>
                        </label>
                    </div>
                </div>

                <div
                    class="relative z-0 w-full mb-2 mt-3 group"
                    v-for="(detail, index) in details"
                    :key="index"
                >
                    <input
                        type="text"
                        :name="'detail' + index"
                        :id="'detail' + index"
                        v-model="details[index]"
                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                        placeholder="Detail"
                    />
                </div>
                <button
                    class="underline hover:text-blue-600"
                    type="button"
                    @click="addDetailInput"
                >
                    Add Detail
                </button>
                <div class="colorInputs mt-3" id="colorInputs">
                    <div
                        v-for="(color, colorIndex) in colors"
                        :key="colorIndex"
                    >
                        <div>
                            <label
                                for="color"
                                class="block text-xs font-medium text-gray-700"
                            >
                                Color
                            </label>
                            <input
                                type="text"
                                v-model="color.name"
                                class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-1.5 px-4 mb-2"
                            />
                        </div>
                        <div
                            v-for="(size, sizeIndex) in color.sizes"
                            :key="sizeIndex"
                        >
                            <div class="grid gap-1 grid-cols-2">
                                <div>
                                    <label
                                        for="color"
                                        class="block text-xs font-medium text-gray-700"
                                    >
                                        Size
                                    </label>
                                    <input
                                        type="text"
                                        v-model="size.name"
                                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-1.5 px-4 mb-2"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="color"
                                        class="block text-xs font-medium text-gray-700"
                                    >
                                        Quantity
                                    </label>
                                    <input
                                        type="number"
                                        v-model="size.quantity"
                                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-1.5 px-4 mb-2"
                                    />
                                </div>
                            </div>
                        </div>
                        <button
                            @click="addSizeInput(colorIndex)"
                            class="underline hover:text-blue-600"
                            type="button"
                        >
                            Add size
                        </button>
                    </div>
                </div>
                <button
                    class="underline hover:text-blue-600"
                    type="button"
                    @click="addColorInput"
                >
                    Add Color
                </button>
                <div class="mt-3">
                    <textarea
                        class="w-full"
                        name="description"
                        v-model="description"
                        id="editor"
                    ></textarea>
                </div>
                <div class="form-group my-4 flex">
                    <label>
                        <input
                            class="size-4 rounded border-gray-300"
                            type="checkbox"
                            name="is_new"
                            v-model="is_new"
                        />
                        <span class="text-red-600 ml-3"
                            ><strong>New</strong></span
                        >
                    </label>
                </div>
                <div
                    v-if="errorMessages.length"
                    class="error-messages mt-1 text-xs text-red-600"
                >
                    <ul>
                        <li
                            class="mt-1"
                            v-for="(error, index) in errorMessages"
                            :key="index"
                        >
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div class="mb-5 mt-2 w-full">
                    <div
                        class="flex py-3 justify-start lg:flex lg:justify-start"
                    >
                        <button
                            type="submit"
                            class="block mr-2 rounded-xl bg-gray-800 px-8 py-2 text-sm text-white transition hover:bg-black"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </Dashboard>
    </div>
</template>
<script>
import axios from "axios";
import Dashboard from "@/components/Dashboard.vue";

export default {
    name: "ProductUpload",
    components: {
        Dashboard,
    },
    data() {
        return {
            errorMessages: [],
            colorCounter: 0,
            colors: [
                {
                    name: "",
                    sizes: [{ name: "", quantity: null }],
                },
            ],
            product_name: "",
            price: "",
            details: [],
            is_new: false,
            description: "",
            gender: "",
            start_datetime: "",
            end_datetime: "",
            discountnumber: "",
            discountquantity: "",
            imageUrl: "",
            class: "",
            images: [],
            productImage: [],
        };
    },
    mounted() {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const uploadUrl = "/api/upload/product/file?_token=" + csrfToken;

        ClassicEditor.create(document.querySelector("#editor"), {
            ckfinder: {
                uploadUrl: uploadUrl,
            },
        })
            .then((editor) => {
                editor.model.document.on("change", () => {
                    this.description = editor.getData();
                });
            })
            .catch((error) => {
                console.error(error);
            });
    },
    methods: {
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleImageUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                this.productImage.push({
                    image: URL.createObjectURL(files[i]),
                    url: files[i],
                });
            }
            this.images = this.productImage.map((item) => item.url);
         },
        addDetailInput() {
            this.details.push("");
        },
        showNotification(message) {
            const notification = document.createElement("div");
            notification.classList.add("notificationAddcart");
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 2100);
        },
        upload() {
            let colorsData = [];
            this.colors.forEach((color) => {
                let sizesData = [];
                color.sizes.forEach((size) => {
                    sizesData.push({
                        name: size.name,
                        quantity: size.quantity,
                    });
                });
                colorsData.push({ name: color.name, sizes: sizesData });
            });
            let formData = new FormData();
            formData.append("product_name", this.product_name);
            formData.append("price", this.price);
            formData.append("class", this.class);
            for (let i = 0; i < this.details.length; i++) {
                formData.append("details[]", this.details[i]);
            }
            formData.append("is_new", this.is_new ? 1 : 0);
            formData.append("description", this.description);
            formData.append("gender", this.gender);
            formData.append("start_datetime", this.start_datetime);
            formData.append("end_datetime", this.end_datetime);
            formData.append("discountnumber", this.discountnumber);
            formData.append("discountquantity", this.discountquantity);
            formData.append("colors", JSON.stringify(colorsData));
            for (let i = 0; i < this.images.length; i++) {
                formData.append("images[]", this.images[i]);
            }
            axios
                .post("/api/upload/product", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    // console.log(response.data);
                    if (response.data.success == true) {
                        this.showNotification(response.data.message);
                    } else {
                        this.errorMessages = response.data.error;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        addColorInput() {
            this.colors.push({
                name: "",
                sizes: [{ name: "", quantity: null }],
            });
        },
        addSizeInput(colorIndex) {
            this.colors[colorIndex].sizes.push({ name: "", quantity: null });
        },
    },
};
</script>
