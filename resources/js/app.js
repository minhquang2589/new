import './bootstrap';
import { createApp } from 'vue';
import App from './app.vue';
import router from './router';
import vScrollAnimation from './directives/scroll-animation.js';
import AOS from 'aos';
import 'aos/dist/aos.css';

import store from './store/index.js';
const app = createApp(App);
// app.directive('scroll-animation', vScrollAnimation);
AOS.init();
app.use(router);
app.use(store);
app.mount('#app');
