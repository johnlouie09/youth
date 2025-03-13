import './assets/main.css'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import axios from 'axios';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import store from './stores';

const app = createApp(App)

const vuetify = createVuetify({
    components,
    theme: {
        dark: true,
    },
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
})

axios.defaults.baseURL = import.meta.env.PROD
    ? `${import.meta.env.BASE_URL}/app`
    : 'http://localhost/youth/app';

app.use(createPinia())
app.use(router)
app.use(store)
app.use(vuetify)

app.mount('#app')
