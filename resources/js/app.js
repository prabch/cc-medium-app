require('./bootstrap');

import 'materialize-css/dist/css/materialize.min.css';
import {createApp} from 'vue';

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

require('./bootstrap');
import App from './App.vue';
import axios from 'axios';
import router from './router';

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.use(VueToast);
app.mount('#app');