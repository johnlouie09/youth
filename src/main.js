import './assets/main.css';
import '@mdi/font/css/materialdesignicons.css'; // Ensure you are using css-loader
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import $ from 'jquery';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import store from './stores/vuex/store';

const app = createApp(App);

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
});

$.ajaxSetup({
    beforeSend: function(xhr, settings) {
        settings.url = import.meta.env.PROD
            ? `${import.meta.env.BASE_URL}/app` + settings.url
            : 'http://localhost/youth/app' + settings.url;
    }
});

app.use(createPinia());
app.use(router);
app.use(store);
app.use(vuetify);

app.mount('#app');
