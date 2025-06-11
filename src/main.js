import './assets/main.css'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import axios from 'axios'
import $ from 'jquery'
import '@fontsource/inter'; // defaults to weight 400

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

// set axios base URL to a relative path
axios.defaults.baseURL = '/app'

// define api_base as a relative path
const api_base = '/app/api.php'
const fullApiUrl = `${window.location.origin}${api_base}`
app.config.globalProperties.$api_base = fullApiUrl // use full URL globally

console.log('Full API URL:', fullApiUrl)

// fetch the CSRF token and set it in the meta tag
$.ajax({
  url: `${fullApiUrl}?e=csrf`,
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

// fetch session info for the logged-in sk-official
$.ajax({
  type: 'GET',
  xhrFields: { withCredentials: true },
  url: `${fullApiUrl}?e=sk-official&a=session`,
  success: (data) => {
    store.commit('auth/setUser', data?.data)
  },
  error: () => {
    // handle session error if needed
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
