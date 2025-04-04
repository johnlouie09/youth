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
        <!-- Forgot Password Link -->
        <!-- <div class="text-right ma-4">
          <a href="#" class="forgot-link">Forgot your password?</a>
        </div>
   -->
        <!-- Login Button with loading prop -->
        <v-btn color="primary" block type="submit" :loading="loading">
          Log In
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import { computed } from 'vue'
import { useTheme } from 'vuetify'
import $ from 'jquery'

export default {
  name: "Login",
  data() {
    return {
      username: '',
      password: '',
      loading: false, // start with false
      usernameError: '',
      passwordError: '',
      requestError: ''
    };
  },
  setup() {
    // Use Vuetify's composable to access theme info
    const theme = useTheme()
    // Create a computed property that returns the proper background gradient
    const backgroundImage = computed(() => {
      return theme.global.current.value.dark
        ? 'linear-gradient(45deg, #363636, #0e0e0e, #363636, #0e0e0e)'
        : 'linear-gradient(45deg, #f0f0f0, #ffffff)';
    });
    
    return { backgroundImage }
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
    async handleSubmit() {
      if (!this.validateForm()) {
        return; // Stop submission if validation fails
      }
  
      // Set loading to true before sending the request
      this.loading = true;

      // Get the CSRF token from the meta tag
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      const api_base = 'http://localhost/youth/app/api.php';
  
      await $.ajax({
        url: `${api_base}?e=sk-official&a=login`,
        type: 'POST',
        xhrFields: {
          withCredentials: true
        },
        data: {
          identifier: this.username,
          password: this.password,
          remember: true
        },
        // Include the CSRF token in the headers
        headers: {
          'X-CSRF-Token': csrfToken
        },
        success: (data) => {
          console.log(data);
          this.$store.commit('auth/setUser', data.data);
          this.$router.replace({ name: 'admin-dashboard', params: { barangaySlug: data.data.barangay.slug } });
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
    }
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  /* The background image is dynamically set via the computed property */
  background-position: center;
  background-attachment: fixed;
}

.login-card {
  width: 30%;
  border-radius: 1rem;
  padding: 3rem 2rem;

  /* Glassmorphism styles */
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
}

.logo-container {
  display: flex;
  justify-content: center;
}

.forgot-link {
  color: #999;
  text-decoration: none;
  font-size: 0.85rem;
}

.forgot-link:hover {
  text-decoration: underline;
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
  color: #fff;
}

.v-text-field .v-field__outline {
  border-color: rgba(255, 255, 255, 0.5) !important;
}

.v-text-field .v-field-label {
  color: rgba(255, 255, 255, 0.7) !important;
}
</style>
