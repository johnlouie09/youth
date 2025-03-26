import './assets/main.css'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import axios from 'axios'
import $ from 'jquery'

import { createApp } from 'vue'
import { createPinia } from 'pinia' 
import App from './App.vue'
import router from './router'
import store from './stores'

const vuetify = createVuetify({
  components,
  theme: {
    dark: true,
  },
  directives,
  icons: {
    defaultSet: 'mdi',
  },
})

const app = createApp(App)

axios.defaults.baseURL = import.meta.env.PROD
  ? `${import.meta.env.BASE_URL}/app`
  : 'http://localhost/youth/app'

const api_base = import.meta.env.PROD
  ? `${import.meta.env.BASE_URL}/app/api.php`
  : 'http://localhost/youth/app/api.php'
app.config.globalProperties.$api_base = api_base

// Fetch the CSRF token and set it in the meta tag.
$.ajax({
  url: `${api_base}?e=csrf`,
  type: 'GET',
  dataType: 'json',
  xhrFields: { withCredentials: true },
  success: function(data) {
    $('meta[name="csrf-token"]').attr('content', data.csrf_token)
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.error('Error fetching CSRF token:', textStatus, errorThrown)
  }
})

// Fetch session info for the logged-in sk-official.
$.ajax({
  type: 'GET',
  xhrFields: { withCredentials: true },
  url: `${api_base}?e=sk-official&a=session`,
  success: (data) => {
    store.commit('auth/setUser', data?.data)
  },
  error: () => {
    // Handle session error if needed.
  },
  complete: () => {
    app.use(router)
    app.use(store)
    app.use(createPinia())
    app.use(vuetify)
    app.mount('#app')
    const token = document.querySelector('meta[name="csrf-token"]')?.content || ''
    store.commit('setCsrfToken', token)
  }
})
