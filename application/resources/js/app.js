import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import router from './router';
import App from '../Vue/App.vue';
import VAnimateCss from 'animate.css';
createApp(App).use(router).use(VAnimateCss).mount('#app');
