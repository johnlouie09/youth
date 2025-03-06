<template>
    <v-container fluid class="login-container">
      <v-card class="login-card" elevation="20">
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
          <!-- Username -->
          <v-text-field
            label="Username"
            prepend-inner-icon="mdi-account"
            variant="outlined"
            density="comfortable"
          />
          <!-- Password -->
          <v-text-field
            label="Password"
            type="password"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            density="comfortable"
          />
          <!-- Forgot Password Link -->
          <div class="text-right mb-4">
            <a href="#" class="forgot-link">Forgot your password?</a>
          </div>
          <!-- Login Button -->
          <v-btn color="primary" block>Log In</v-btn>
      </v-card>
    </v-container>
  </template>
  
  <script setup>
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
  