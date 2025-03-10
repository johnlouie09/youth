<template>
  <v-container fluid class="login-container theme--dark">
    <v-card class="login-card" elevation="20" dark>
      <!-- Logo centered above the form -->
      <div>
        <v-img
          src="/public//Flogo.svg"
          max-width="300"
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
        <!-- Forgot Password Link -->
        <div class="text-right mb-4">
          <a href="#" class="forgot-link">Forgot your password?</a>
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
import $ from 'jquery';

export default {
  name: "Login",
  data() {
    return {
      username: '',
      password: '',
      loading: false, // start with false
      usernameError: '',
      passwordError: '',
    };
  },
  methods: {
    // Validates if the required fields are populated.
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

      const api_base = 'http://localhost/youth/app/api.php';
      
      await $.ajax({
        url: `${api_base}?e=sk-official&a=login`, // appending the query parameter
        type: 'POST',
        xhrFields: {
          withCredentials: true
        },
        data: {
          identifier: this.username,
          password: this.password,
          remember: true
        },
        success: (data) => {
          console.log("Success:", data);
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error:", textStatus, errorThrown);
        },
        complete: () => {
          // Set loading to false once the request is done (either success or error)
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
}

.login-card {
  width: 30%;
  border-radius: 1.5rem;
  padding: 3rem 2rem;
}

.forgot-link {
  color: #999;
  text-decoration: none;
  font-size: 0.85rem;
}

.forgot-link:hover {
  text-decoration: underline;
}
</style>
