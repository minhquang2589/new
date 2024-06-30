import { createRouter, createWebHistory } from 'vue-router';
import { mapGetters, mapMutations, mapActions, mapState } from "vuex";

import axios from 'axios';
import store from './store/';
import Layout from "@/components/Layout.vue";
import Home from './components/Home.vue';
import Product from "@/components/product/Product.vue";
import EditProduct from "@/components/product/Edit.vue";
import Bestseller from "@/components/product/Bestseller.vue";
import Clothes from "@/components/layout/Clothes.vue";
import Hat from "@/components/layout/Hat.vue";
import Bag from "@/components/layout/Bag.vue";
import Shoe from "@/components/layout/Shoe.vue";
import Accessory from "@/components/layout/Accessory.vue";
import Men from "@/components/product/Men.vue";
import Women from "@/components/product/Women.vue";
import Discount from "@/components/product/Discount.vue";
import Unisex from "@/components/product/Unisex.vue";
import NewProduct from "@/components/product/NewProduct.vue";
import ProductUpload from "@/components/product/Upload.vue";
import ProductUpdate from "@/components/product/Update.vue";
import VouchersUpload from "@/components/vouchers/Upload.vue";
import VouchersUpdate from "@/components/vouchers/Update.vue";
import EditVoucher from "@/components/vouchers/Edit.vue";
import ViewProduct from "@/components/view/ViewProduct.vue";
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import Cart from './components/layout/Cart.vue';
import Checkout from './components/layout/Checkout.vue';
import Error from './components/layout/Error.vue';
import Confirm from './components/layout/Confirm.vue';
import Payment from './components/layout/Payment.vue';
import sectionUpload from './components/section/Upload.vue';
import sectionUpdate from './components/section/Update.vue';
import EditSection from './components/section/Edit.vue';
import SliderUpload from './components/slider/Upload.vue';
import SliderUpdate from './components/slider/Update.vue';
import EditSlider from './components/slider/Edit.vue';
import Blog from "@/components/blog/Blog.vue";
import blogUpdate from "@/components/blog/Update.vue";
import blogUpload from "@/components/blog/Upload.vue";
import EditBlog from "@/components/blog/Edit.vue";
import Contact from "@/components/contact/Contact.vue";
import About from "@/components/about/About.vue";
import DiscountUpdate from "./components/discount/Update.vue";
import EditDiscount from "./components/discount/Edit.vue";
import Customers from './components/customers/Customers.vue';
import Orders from './components/order/Orders.vue';
import OrderDetails from './components/order/Details.vue';
import Users from './components/user/Users.vue';
import editUser from './components/user/Edit.vue';
import RecentlyProduct from "./components/product/RecentlyProduct.vue";
import Video from "./components/video/Video.vue";
import videoUpload from './components/video/Upload.vue';
import videoUpdate from './components/video/Update.vue';
import editVideo from './components/video/Edit.vue';
import shopUpload from "./components/shop/Upload.vue";
import shopUpdate from "./components/shop/Update.vue";
import editShop from "./components/shop/Edit.vue";
import SearchResults from './components/search/SearchResults.vue';
import sizeUpload from './components/sizechart/upload.vue';
import sizeUpdate from './components/sizechart/update.vue';
import editSizeChart from "./components/sizechart/edit.vue";
import sliderBagUpload from "./components/sliderbag/Upload.vue";
import sliderBagUpdate from "./components/sliderbag/Update.vue";
import EditSliderBag from "./components/sliderbag/Edit.vue";
import Lookbook from "./components/lookbook/Lookbook.vue";
import lookbookUpload from "./components/lookbook/Upload.vue";
import viewLookbook from "./components/lookbook/View.vue";
import lookbookUpdate from "./components/lookbook/Update.vue";
import editLookbook from "./components/lookbook/Edit.vue";
import aboutUpload from "./components/about/Upload.vue";
import aboutUpdate from "./components/about/Update.vue";
import editAbout from "./components/about/Edit.vue";
import Item from "./components/Item.vue";
import contactUpload from "./components/contact/Upload.vue";
import contactUpdate from "./components/contact/Update.vue";
import contactEdit from "./components/contact/Edit.vue";
import user from './store/modules/user';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: Layout,
      children: [
        {
          path: '',
          name: 'Home',
          component: Home,
          meta: { title: 'Home', showSection: true, showSlider: true, showSliderSale: true, showSliderRecently: true, showShop: true, showDiscountSection: true }
        },
        {
          path: 'product',
          name: 'Product',
          component: Product,
          meta: { title: 'Products', showSlider: true }
        },
        {
          path: 'login',
          name: 'Login',
          component: Login,
          meta: { title: 'Login', hideFooter: true, hideHeader: true }
        },
        {
          path: 'register',
          name: 'Register',
          component: Register,
          meta: { title: 'Register', hideFooter: true, hideHeader: true }
        },
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          props: true,
          meta: { title: 'Dashboard', requiresAdmin: true }
        },
        {
          path: 'product/upload',
          name: 'Upload',
          component: ProductUpload,
          props: true,
          meta: { title: 'Product - Upload', requiresAdmin: true, }
        },
        {
          path: 'product/update',
          name: 'UpDate',
          component: ProductUpdate,
          props: true,
          meta: { title: 'Product - Update', requiresAdmin: true, }
        },
        {
          path: '/products/:id-:productName',
          name: 'ViewProduct',
          component: ViewProduct,
          props: true,
          meta: { title: 'Product - View', }
        },
        {
          path: 'product/bestseller',
          name: 'Bestseller',
          component: Bestseller,
          meta: { title: 'Product - Bestsellers', showSlider: true }
        },
        {
          path: 'product/men',
          name: 'Men',
          component: Men,
          meta: { title: 'Product - Men', showSlider: true }
        },
        {
          path: 'product/new',
          name: 'NewProduct',
          component: NewProduct,
          meta: { title: 'Product - New', showSlider: true }
        },
        {
          path: 'product/women',
          name: 'Women',
          component: Women,
          meta: { title: 'Product - Women', showSlider: true }
        },
        {
          path: 'video',
          name: 'Video',
          component: Video,
          meta: { title: 'Shop - Video', showSlider: true }
        },
        {
          path: 'product/unisex',
          name: 'Unisex',
          component: Unisex,
          meta: { title: 'Product - Unisex', showSlider: true }
        },
        {
          path: 'product/discount',
          name: 'Discount',
          component: Discount,
          meta: { title: 'Product - Discount', showSlider: true }
        },
        {
          path: 'product/hat',
          name: 'Hat',
          component: Hat,
          meta: { title: 'Product - Hat', showSlider: true }
        },
        {
          path: 'product/Bag',
          name: 'Bag',
          component: Bag,
          meta: { title: 'Product - Bag', showSlider: true }
        },
        {
          path: 'product/accessory',
          name: 'Accessory',
          component: Accessory,
          meta: { title: 'Product - Accessory', showSlider: true }
        },
        {
          path: 'product/shoes',
          name: 'Shoe',
          component: Shoe,
          meta: { title: 'Product - Shoes', showSlider: true }
        },
        {
          path: 'product/clothes',
          name: 'Clothes',
          component: Clothes,
          meta: { title: 'Product - Clothes', showSlider: true }
        },
        {
          path: 'cart',
          name: 'Cart',
          component: Cart,
          meta: { title: 'Cart', }
        },
        {
          path: '/checkout',
          name: 'Checkout',
          component: Checkout,
          meta: { title: 'Checkout', }
        },
        {
          path: 'payment',
          name: 'Payment',
          component: Payment,
          meta: { title: 'Payment', }
        },
        {
          path: 'error',
          name: 'Error',
          component: Error,
          meta: { title: 'Error', }
        },
        {
          path: 'confirm',
          name: 'Confirm',
          component: Confirm,
          meta: { title: 'Thank You', }
        },
        {
          path: 'vouchers/upload',
          name: 'VouchersUpload',
          component: VouchersUpload,
          meta: { title: 'Vouchers - Upload', requiresAdmin: true, }
        },
        {
          path: 'vouchers/update',
          name: 'VouchersUpdate',
          component: VouchersUpdate,
          meta: { title: 'Vouchers - Update', requiresAdmin: true, }
        },
        {
          path: 'vouchers/edit/:id',
          name: 'EditVoucher',
          component: EditVoucher,
          props: true,
          meta: { title: 'Vouchers - Edit', requiresAdmin: true, }
        },
        {
          path: 'product/edit/:id',
          name: 'EditProduct',
          component: EditProduct,
          props: true,
          meta: { title: 'Product - Edit', requiresAdmin: true, }
        },
        {
          path: 'section/upload',
          name: 'sectionUpload',
          component: sectionUpload,
          meta: { title: 'Section - Upload', requiresAdmin: true, }
        },
        {
          path: 'section/update',
          name: 'sectionUpdate',
          component: sectionUpdate,
          meta: { title: 'Section - Update', requiresAdmin: true, }
        },
        {
          path: 'section/edit/:id',
          name: 'EditSection',
          component: EditSection,
          props: true,
          meta: { title: 'Section - Edit', requiresAdmin: true, }
        },
        {
          path: 'slider/upload',
          name: 'SliderUpload',
          component: SliderUpload,
          meta: { title: 'Slider - Upload', requiresAdmin: true, }
        },
        {
          path: 'slider/update',
          name: 'SliderUpdate',
          component: SliderUpdate,
          meta: { title: 'Slider - Update', requiresAdmin: true, }
        },
        {
          path: 'slider/edit/:id',
          name: 'EditSlider',
          component: EditSlider,
          props: true,
          meta: { title: 'Slider - Edit', requiresAdmin: true, }
        },
        {
          path: 'blog',
          name: 'Blog',
          component: Blog,
          meta: { title: 'Blog' }
        },
        {
          path: 'blog/upload',
          name: 'blogUpload',
          component: blogUpload,
          meta: { title: 'Blog - Upload', requiresAdmin: true, }
        },
        {
          path: 'blog/update',
          name: 'blogUpdate',
          component: blogUpdate,
          meta: { title: 'BLog - Update', requiresAdmin: true, }
        },
        {
          path: 'blog/edit/:id',
          name: 'EditBlog',
          component: EditBlog,
          props: true,
          meta: { title: 'BLog - Edit', requiresAdmin: true, }
        },
        {
          path: 'contact',
          name: 'Contact',
          component: Contact,
          meta: { title: 'Contact' }
        },
        {
          path: 'about',
          name: 'About',
          component: About,
          meta: { title: 'About' }
        },
        {
          path: 'discount/update',
          name: 'DiscountUpdate',
          component: DiscountUpdate,
          meta: { title: 'Discount - Update', requiresAdmin: true, }
        },
        {
          path: 'discount/edit/:id',
          name: 'EditDiscount',
          component: EditDiscount,
          props: true,
          meta: { title: 'Discount - Edit', requiresAdmin: true, }
        },
        {
          path: 'customers',
          name: 'Customers',
          component: Customers,
          meta: { title: 'Customers', requiresAdmin: true, }
        },
        {
          path: 'orders',
          name: 'Orders',
          component: Orders,
          meta: { title: 'Orders', requiresAdmin: true, }
        },
        {
          path: 'order/details/:id',
          name: 'OrderDetails',
          component: OrderDetails,
          props: true,
          meta: { title: 'Order Details', requiresAdmin: true, }
        },
        {
          path: 'account/users',
          name: 'Users',
          component: Users,
          meta: { title: 'Users', requiresAdmin: true, }
        },
        {
          path: 'user/edit/:id',
          name: 'editUser',
          component: editUser,
          props: true,
          meta: { title: 'User - Edit', requiresAdmin: true, }
        },
        {
          path: 'product/recently',
          name: 'RecentlyProduct',
          component: RecentlyProduct,
          meta: { title: 'Product - Recently', showSlider: true, }
        },
        {
          path: 'video/upload',
          name: 'videoUpload',
          component: videoUpload,
          meta: { title: 'Videos - Update', requiresAdmin: true, }
        },
        {
          path: 'video/update',
          name: 'videoUpdate',
          component: videoUpdate,
          meta: { title: 'Vides - Update', requiresAdmin: true, }
        },
        {
          path: 'video/edit/:id',
          name: 'editVideo',
          component: editVideo,
          props: true,
          meta: { title: 'Video - Edit', requiresAdmin: true, }
        },
        {
          path: 'shop/upload',
          name: 'Shop',
          component: shopUpload,
          meta: { title: 'Shop - Upload', requiresAdmin: true, }
        },
        {
          path: 'shop/update',
          name: 'shopUpdate',
          component: shopUpdate,
          meta: { title: 'Shop - Update', requiresAdmin: true, }
        },
        {
          path: 'shop/edit/:id',
          name: 'editShop',
          component: editShop,
          props: true,
          meta: { title: 'Shop - Edit', requiresAdmin: true, }
        },
        {
          path: '/search',
          name: 'SearchResults',
          component: SearchResults,
          meta: { title: 'Search' }

        },
        {
          path: 'sizechart/upload',
          name: 'sizechartUpload',
          component: sizeUpload,
          meta: { title: 'Size chart - Upload', requiresAdmin: true, }
        },
        {
          path: 'sizechart/update',
          name: 'sizeUpdate',
          component: sizeUpdate,
          meta: { title: 'Size chart - Update', requiresAdmin: true, }
        },
        {
          path: 'size/edit/:id',
          name: 'editSizeChart',
          component: editSizeChart,
          props: true,
          meta: { title: 'Size chart - Edit', requiresAdmin: true, }
        },
        {
          path: 'slider/bag/upload',
          name: 'SliderBagUpload',
          component: sliderBagUpload,
          meta: { title: 'Slider bag - Upload', requiresAdmin: true, }
        },
        {
          path: 'slider/bag/update',
          name: 'sliderBagUpdate',
          component: sliderBagUpdate,
          meta: { title: 'Slider bag - Update', requiresAdmin: true, }
        },
        {
          path: 'siler/bag/edit/:id',
          name: 'EditSliderBag',
          component: EditSliderBag,
          props: true,
          meta: { title: 'Slider bag - Edit', requiresAdmin: true, }
        },
        {
          path: 'lookbook',
          name: 'Lookbook',
          component: Lookbook,
          meta: { title: 'Lookbook' }
        },
        {
          path: 'lookbook/upload',
          name: 'lookbookUpload',
          component: lookbookUpload,
          meta: { title: 'Lookbooks - Upload', requiresAdmin: true, }
        },
        {
          path: 'lookbook/:id',
          name: 'viewLookbook',
          component: viewLookbook,
          props: true,
          meta: { title: 'Lookbook', }
        },
        {
          path: 'lookbook/update',
          name: 'lookbookUpdate',
          component: lookbookUpdate,
          meta: { title: 'Lookbooks - Update', requiresAdmin: true, }
        },
        {
          path: 'lookbook/edit/:id',
          name: 'editLookbook',
          component: editLookbook,
          props: true,
          meta: { title: 'Lookbook - Edit', requiresAdmin: true, }
        },
        {
          path: 'about/upload',
          name: 'aboutUpload',
          component: aboutUpload,
          meta: { title: 'About - Upload', requiresAdmin: true, }
        },
        {
          path: 'about/update',
          name: 'aboutUpdate',
          component: aboutUpdate,
          meta: { title: 'About - Update', requiresAdmin: true, }
        },
        {
          path: 'about/edit/:id',
          name: 'editAbout',
          component: editAbout,
          meta: { title: 'About - Edit', requiresAdmin: true, }
        },
        {
          path: 'shop/item',
          name: 'Item',
          component: Item,
          meta: { title: 'Shop - items', requiresAdmin: true, }
        },
        {
          path: 'contact/upload',
          name: 'contactUpload',
          component: contactUpload,
          meta: { title: 'Contact - Upload', requiresAdmin: true, }
        },
        {
          path: 'contact/update',
          name: 'contactUpdate',
          component: contactUpdate,
          meta: { title: 'Contact - Update', requiresAdmin: true, }
        },
        {
          path: 'contact/edit/:id',
          name: 'contactEdit',
          component: contactEdit,
          meta: { title: 'Contact - Edit', requiresAdmin: true, }
        },
      ]
    },
    {
      path: '/:pathMatch(.*)*',
      redirect: { name: 'Error', params: {} }
    }
  ],
});


router.beforeEach(async (to, from, next) => {
  let title = to.meta.title;

  if (to.name === 'ViewProduct') {
    const productName = to.params.productName || 'Product';
    const category = to.params.category || '';
    title = `${productName} - ${'web.com'}`;
  }
  document.title = title;
  window.scrollTo(0, 0);
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);
  if (requiresAdmin) {
    // await store.dispatch('fetchUser');
    const isAdmin = store.getters.isAdmin;
    const isAuthenticated = store.getters.isAuthenticated;
    // console.log(isAuthenticated);
    if (isAdmin && isAuthenticated) {
      next();
    } else {
      next({ name: 'Home' });
    }
  } else {
    next();
  }
});


export default router;
