<template>
    <Dashboard page-title="Product - Edit">
        <form
            class="max-w-md px-3 lg:px-0 mx-auto"
            @submit.prevent="productEdit"
        >
            <span class="underline text-red-500 hover:cursor-pointer">
                <p @click="deleteProduct">Delete product</p>
            </span>
            <div class="z-0 mb-5 mt-4 group">
                <div class="grid gap-1 grid-cols-3">
                    <div
                        v-for="(item, index) in productImage"
                        :key="index"
                        class="mr-2"
                    >
                        <img
                            class="size-28"
                            :src="getImageSrc(item.image)"
                            :alt="`Image ${index + 1}`"
                        />
                    </div>
                </div>
                <div class="my-5">
                    <button
                        type="button"
                        @click="triggerFileInput"
                        class="underline hover:text-blue-600"
                    >
                        Change
                    </button>
                    <button
                        v-if="productImage.length"
                        type="button"
                        @click="deleteImage"
                        class="underline ml-2 mt-4 hover:text-blue-600"
                    >
                        Delete
                    </button>
                    <input
                        ref="fileInput"
                        @change="handleImageUpload"
                        class="hidden"
                        type="file"
                        id="image-input"
                        name="images[]"
                        multiple
                    />
                </div>
            </div>
            <div class="relative z-0 mb-2 mt-4 group">
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
                    @blur="formatPrice"
                    @input="formatPrice"
                    v-model="price"
                    placeholder="Price"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                />
                <label
                    for="gender"
                    class="block text-xs font-medium text-gray-700"
                >
                    Gender
                </label>
                <select
                    id="gender"
                    for="gender"
                    name="gender"
                    v-model="gender"
                    class="block w-full mb-2 px-2 sm:px-3 lg:px-2 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option hidden selected disabled>Choose a gender</option>
                    <option for="gender" value="Men">Men</option>
                    <option for="gender" value="Women">Women</option>
                    <option for="gender" value="Unisex">Unisex</option>
                </select>
                <label
                    for="Class"
                    class="block text-xs font-medium text-gray-700"
                >
                    Class
                </label>
                <select
                    id="class"
                    for="class"
                    name="class"
                    v-model="class"
                    class="block w-full mb-2 px-2 lg:px-2 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option hidden selected disabled>Choose a class</option>
                    <option for="class" value="clothes">clothes</option>
                    <option for="class" value="bag">bag</option>
                    <option for="class" value="hat">hat</option>
                    <option for="class" value="shoe">shoe</option>
                    <option for="class" value="accessory">accessory</option>
                </select>
            </div>
            <div class="colorInputs mb-2" id="colorInputs">
                <div v-for="(color, colorIndex) in colors" :key="colorIndex">
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
                class="underline mb-2 hover:text-blue-600"
                type="button"
                @click="addColorInput"
            >
                Add color
            </button>
            <div class="grid gap-1 grid-cols-2">
                <div>
                    <label
                        for="color"
                        class="block text-xs font-medium text-gray-700"
                    >
                        Discount
                    </label>
                    <input
                        type="number"
                        v-model="discountnumber"
                        name="discountnumber"
                        placeholder="Discount %"
                        min="1"
                        max="100"
                        oninput="validity.valid||(value='');"
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
                        name="discountquantity"
                        placeholder="Discount Quantity"
                        min="0"
                        v-model="discountquantity"
                        oninput="validity.valid||(value='');"
                        class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-1.5 px-4 mb-2"
                    />
                </div>
            </div>
            <label for="start_datetime" class="text-sm">Start discount:</label>
            <input
                type="datetime-local"
                class="text-sm"
                v-model="start_datetime"
                id="start_datetime"
                name="start_datetime"
            />
            <br />
            <label for="end_datetime" class="text-sm">End discount:</label>
            <input
                type="datetime-local"
                id="end_datetime"
                class="text-sm"
                name="end_datetime"
                v-model="end_datetime"
            />

            <!-- <div
                class="relative z-0 w-full mb-2 mt-3 group"
                v-for="(detail, index) in details"
                :key="index"
            >
                <input
                    type="text"
                    :name="'detail' + index"
                    :id="'detail' + index"
                    v-model="details[index]"
                    placeholder="Details"
                    class="text-sm border border-gray-300 appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-2 px-4 mb-2"
                />
            </div>
            <button
                class="underline hover:text-blue-600"
                type="button"
                @click="addDetailInput"
            >
                Add Detail
            </button> -->

            <div class="mt-3">
                <textarea
                    class="w-full"
                    name="description"
                    v-model="description"
                    id="editor"
                ></textarea>
            </div>
            <div class="form-group flex mt-3">
                <label>
                    <input
                        class="size-4 rounded border-gray-300"
                        type="checkbox"
                        name="is_new"
                        v-model="is_new"
                        :checked="is_new === 1"
                    />
                    <span class="ml-3"><strong>New</strong></span>
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
                        ‰
                    >
                        {{ error }}
                    </li>
                </ul>
            </div>

            <div class="mb-5 mt-2 w-full">
                <div class="flex py-3 justify-start lg:flex lg:justify-start">
                    <LoadingButton
                        class="block mr-2 rounded-xl bg-gray-800 px-8 py-2 text-sm text-white transition hover:bg-black"
                        :loading="isLoadingButton"
                    >
                        <button>Submit</button>
                    </LoadingButton>
                </div>
            </div>
        </form>
    </Dashboard>
    <LoadingSpinner :isLoading="isLoading" />
</template>
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import Dashboard from "@/components/Dashboard.vue";
import LoadingSpinner from "../layout/LoadingSpinner.vue";
import Swal from "sweetalert2";
import LoadingButton from "../layout/LoadingButton.vue";

export default {
    name: "EditProduct",
    props: ["id"],
    components: {
        Dashboard,
        LoadingSpinner,
        LoadingButton,
    },
    data() {
        return {
            errorMessages: [],
            colorCounter: 0,
            colors: [],
            product_name: "",
            price: "",
            details: [],
            is_new: false,
            description: "",
            gender: "",
            class: "",
            start_datetime: "",
            end_datetime: "",
            discountnumber: "",
            discountquantity: "",
            discountremaining: "",
            imageUrl: "",
            content: "",
            images: [],
            blogs: "",
            productImage: [],
            isLoading: true,
            isLoadingButton: false,
        };
    },
    mounted() {
        this.getProductData();
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
                this.editorInstance = editor;
                editor.model.document.on("change", () => {
                    this.description = editor.getData();
                });
                if (this.description) {
                    editor.setData(this.description);
                }
            })
            .catch((error) => {
                console.error(error);
            });
    },
    computed: {
        ...mapGetters(["notification", "formatCurrencyInput"]),
    },
    methods: {
        deleteImage() {
            this.productImage = [];
        },
        ...mapActions(["showNotification"]),
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        async deleteProduct() {
            const productId = this.$route.params.id;
            const result = await Swal.fire({
                title: "Are you sure you want to delete?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                customClass: {
                    popup: "confirmDeleteContainer",
                    title: "fonfirm_delete_title",
                    confirmButton: "confirm_delete_button",
                    cancelButton: "confirm_cancel_button",
                },
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.delete(
                        `/api/product/delete/${productId}`
                    );
                    // console.log(response.data);
                    if (response.data.success == true) {
                        this.$router.push({ name: "Dashboard" });
                    }
                } catch (error) {
                    console.error("Error deleting product:", error);
                }
            }
        },
        async getProductData() {
            try {
                const productId = this.$route.params.id;
                const response = await axios.get(
                    `/api/product/edit/${productId}`
                );
                // console.log(response.data);
                if (response.data.success == true) {
                    this.product_name = response.data.product.name;
                    this.price = this.formatCurrencyInput(
                        response.data.product.price
                    );
                    this.description = response.data.product.description;
                    this.gender = response.data.productCate.gender;
                    this.class = response.data.product.class;
                    this.is_new = response.data.product.is_new;
                    this.productImage = response.data.productImages;
                    const colorsData = [];
                    const { colors, sizes, quantities } = response.data;
                    for (let i = 0; i < colors.length; i++) {
                        const colorName = colors[i];
                        const sizeName = sizes[i];
                        const quantity = quantities[i];
                        let color = colorsData.find(
                            (c) => c.name === colorName
                        );
                        if (!color) {
                            color = { name: colorName, sizes: [] };
                            colorsData.push(color);
                        }
                        color.sizes.push({ name: sizeName, quantity });
                    }
                    this.colors = colorsData;
                    if (response.data.discountInfo) {
                        this.discountnumber =
                            response.data.discountInfo.discount;
                        this.discountquantity =
                            response.data.discountInfo.total_quantity;
                        this.start_datetime =
                            response.data.discountInfo.start_datetime;
                        this.end_datetime =
                            response.data.discountInfo.end_datetime;
                        this.discountremaining =
                            response.data.discountInfo.remaining;
                    }
                    this.description = response.data.product.description;
                    if (this.editorInstance) {
                        this.editorInstance.setData(this.description);
                    }
                    this.isLoading = false;
                } else {
                    console.log(" edit error.");
                }
            } catch (error) {
                this.isLoading = false;
                console.error("Error fetching data:", error);
            }
        },
        formatPrice() {
            this.price = this.formatCurrencyInput(this.price);
        },
        handleImageUpload(event) {
            const files = event.target.files;
            this.productImage = [];
            for (let i = 0; i < files.length; i++) {
                this.productImage.push({
                    image: URL.createObjectURL(files[i]),
                    url: files[i],
                });
            }
            this.images = this.productImage.map((item) => item.url);
        },
        getImageSrc(imagePath) {
            if (imagePath.startsWith("blob:")) {
                return imagePath;
            } else {
                return `/images/${imagePath}`;
            }
        },
        productEdit() {
            this.isLoadingButton = true;

            const productId = this.$route.params.id;
            const priceWithoutCurrency = this.price.replace(/[^\d]/g, "");
            const numericPrice = parseFloat(priceWithoutCurrency);
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
            formData.append("price", numericPrice);
            // for (let i = 0; i < this.details.length; i++) {
            //     formData.append("details[]", this.details[i]);
            // }
            formData.append("is_new", this.is_new ? 1 : 0);
            formData.append("description", this.description);
            formData.append("gender", this.gender);
            formData.append("start_datetime", this.start_datetime);
            formData.append("end_datetime", this.end_datetime);
            formData.append("discountnumber", this.discountnumber);
            formData.append("discountquantity", this.discountquantity);
            formData.append("discountremaining", this.discountremaining);
            formData.append("productId", productId);
            formData.append("colors", JSON.stringify(colorsData));
            for (let i = 0; i < this.images.length; i++) {
                formData.append("images[]", this.images[i]);
            }
            axios
                .post("/api/update/product", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log(response.data);
                    if (response.data.success == true) {
                        this.showNotification(response.data.message);
                        this.getProductData();
                        this.isLoadingButton = false;
                    } else {
                        this.isLoadingButton = false;
                        this.errorMessages = response.data.error;
                    }
                })
                .catch((error) => {
                    this.isLoadingButton = false;
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
        addDetailInput() {
            this.details.push("");
        },
    },
};
</script>
<style>
.confirm_cancel_button {
    font-size: 14px !important;
    padding: 5px 10px !important;
    color: white !important;
    background-color: gray !important;
}

.confirm_delete_button {
    font-size: 14px !important;
    padding: 5px 10px !important;
    color: white !important;
    background-color: black !important;
}
</style>
