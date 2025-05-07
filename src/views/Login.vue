<template>
  <v-container
    fluid
    class="login-container"
    :style="{ backgroundImage: backgroundImage }"
  >
    <v-card class="login-card" elevation="20">
      <!-- Logo centered above the form -->
      <div class="logo-container">
        <v-img
          src="/public/Flogo.svg"
          max-width="220"
          class="mx-auto mb-5"
        />
      </div>
      
      <!-- Title -->
      <div class="text-h5 text-center mb-4">LOG IN</div>
      <v-form @submit.prevent="handleSubmit">
        <!-- Username -->
        <v-text-field
          v-model="username"
          label="Username"
          prepend-inner-icon="mdi-account"
          variant="outlined"
          density="comfortable"
          :error-messages="usernameError"
          :disabled="loading"
        />
        <!-- Password -->
        <v-text-field
          v-model="password"
          label="Password"
          type="password"
          prepend-inner-icon="mdi-lock"
          variant="outlined"
          density="comfortable"
          :error-messages="passwordError"
          :disabled="loading"
        />

        <div class="reqErr" v-if="requestError">
          {{ requestError.toUpperCase() }}
        </div>
        
        
        <!-- Login Button with loading prop -->
        <v-btn color="primary" block type="submit" :loading="loading">
          Log In
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import { computed } from 'vue';
import { useTheme } from 'vuetify';
import $ from 'jquery';
import debounce from 'lodash/debounce'

export default {
  name: "Login",
  data() {
    return {
      username: '',
      password: '',
      loading: false,
      loading: false,
      usernameError: '',
      passwordError: '',
      requestError: '',
      dialog: false, // controls the Privacy Policy dialog
      requestError: '',
      dialog: false // controls the Privacy Policy dialog
    };
  },
  setup() {
      const theme = useTheme();
      const backgroundImage = computed(() => {
          return theme.global.current.value.dark
              ? 'linear-gradient(45deg, #363636, #0e0e0e, #363636, #0e0e0e)'
              : 'linear-gradient(45deg, #f0f0f0, #ffffff)';
      });
      return { backgroundImage };
  },
  methods: {
      validateForm() {
          let valid = true;
          this.usernameError = '';
          this.passwordError = '';

          if (!this.username.trim()) {
              this.usernameError = 'Username is required';
              valid = false;
          }
          if (!this.password.trim()) {
              this.passwordError = 'Password is required';
              valid = false;
          }

          if (!valid) {
              console.log("Validation failed: Required fields are missing.");
          }

          return valid;
      },
      handleSubmit: debounce(async function() {
          if (!this.validateForm()) {
              return;
          }

          this.loading = true;
          this.requestError = '';
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
          if (!csrfToken) {
              this.requestError = "CSRF token missing. Please refresh the page.";
              this.loading = false;
              return;
          }

          await $.ajax({
              url: `${this.$store.getters['api_base']}?e=sk-official&a=login`,
              type: 'POST',
              xhrFields: { withCredentials: true },
              data: {
                  identifier: this.username,
                  password: this.password,
                  remember: true
              },
              headers: { 'X-CSRF-Token': csrfToken },
              success: (data) => {
                  this.$store.commit('auth/setUser', data.data);
                  const barangaySlug = data?.data?.barangay?.slug;
                  if (!barangaySlug) {
                      this.requestError = "Invalid response from server. Missing barangay slug.";
                      return;
                  }
                  this.$router.replace({ name: 'admin-dashboard', params: { barangaySlug }});
                  this.requestError = '';
              },
              error: (jqXHR, textStatus, errorThrown) => {
                  console.error("Error:", textStatus, errorThrown);
                  let errorMsg = "An error occurred while processing your request.";
                  if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                      errorMsg = jqXHR.responseJSON.message;
                  } else if (jqXHR.responseText) {
                      errorMsg = jqXHR.responseText;
                  }
                  this.requestError = errorMsg;
              },
              complete: () => {
                  this.loading = false;
              }
          });
      }, 300)
  }
};
</script>

<style scoped>
.login-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-position: center;
    background-attachment: fixed;
    gap: 1.5rem;
}

.login-card {
    width: 90%;
    max-width: 500px;
    border-radius: 1rem;
    padding: 3rem 2rem;
    background: rgba(255, 255, 255, 0);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
}

.logo-container {
    display: flex;
    justify-content: center;
}

.primary {
    cursor: pointer;
    color: #fff;
    text-decoration: underline;
}

.privacy-toggle:hover {
    opacity: 0.8;
}

.reqErr {
    width: 100%;
    display: flex;
    justify-content: center;
    color: rgb(245, 49, 49);
    margin-bottom: 1rem;
    font-size: 120%;
}

.v-text-field {
    margin-bottom: 1.5rem;
}

.v-text-field .v-icon {
    color: var(--v-theme-on-surface);
}

.v-text-field .v-field-label {
    color: var(--v-theme-on-surface) !important;
}

.dialog {
    padding: 1rem;
}
</style>
