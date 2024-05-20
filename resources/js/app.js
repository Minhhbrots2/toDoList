import { createApp } from 'vue';
import router from './router';
import App from './components/App.vue';
import axios from 'axios';
import '../css/scss/main.scss';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCirclePlus, faTrash } from '@fortawesome/free-solid-svg-icons';

import Toast, { POSITION } from 'vue-toastification'
import 'vue-toastification/dist/index.css'

// Thiết lập FontAwesome
library.add(faCirclePlus, faTrash);
dom.watch();

// Thiết lập axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found');
}

// Tạo và cấu hình Vue app
const app = createApp(App);
app.use(router);
app.use(Toast, {
  position: POSITION.TOP_RIGHT,
  timeout: 5000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: 'button',
  icon: true,
  rtl: false
});
app.component('font-awesome-icon', FontAwesomeIcon);
app.mount('#app');