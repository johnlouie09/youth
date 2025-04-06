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

    <!-- Privacy Policy Toggle -->
    <v-btn
      variant="text"
      class="privacy-toggle"
      color="primary"
      @click="dialog = true"
    >
      Privacy Policy
    </v-btn>

<!-- Privacy Policy Dialog -->
<v-dialog v-model="dialog" width="80%" scrollable persistent>
  <v-card class="rounded-2xl p-6 bg-white text-gray-800">
    
    <!-- Header -->
    <v-card-title class="text-2xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-red-500 to-yellow-400">
      YOUTH Privacy Policy & User Agreement
    </v-card-title>

    <v-divider class="my-4" />

    <!-- Scrollable Content -->
    <v-card-text class="max-h-[70vh] px-10 overflow-y-auto space-y-6 text-base">
      <section>
        <h2 class="text-lg font-semibold text-gray-900">Consent and Acceptance</h2>
        <p>
          By using the YOUTH Platform, you agree to the terms of this Agreement and our handling of your Personal Data in accordance with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Collection</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>For SK Officials: name, email, contact number, profile photo, position, birthday, motto, and term duration.</li>
          <li>For Youth Users: system interaction data.</li>
          <li>For all users: browser info, IP address, and logs for security.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Purpose of Data Use</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>To display SK profiles for transparency.</li>
          <li>To generate governance and project reports.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Retention & Security</h2>
        <p>
          Your data is securely stored and retained only as long as necessary for documentation and governance purposes.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Sharing</h2>
        <p>
          Data may be shared only with authorized entities such as LGUs, YOUTH Platform Dev Team, or legal authorities if required. Your data is never sold.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Your Rights</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>Right to be informed, access, correct, or delete your data.</li>
          <li>Right to object or withdraw consent under lawful conditions.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Limitation of Liability</h2>
        <p>
          YOUTH is not liable for data loss due to user negligence, unauthorized access, or technical failures beyond our control.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Governing Law</h2>
        <p>
          This Agreement is governed by the laws of the Republic of the Philippines and any disputes shall be settled in the courts of Iriga City.
        </p>
      </section>

    </v-card-text>

    <!-- Close Button -->
    <v-card-actions class="mt-4 justify-end">
      <v-btn color="primary" variant="elevated" @click="dialog = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>



    <!-- Privacy Policy Toggle -->
    <v-btn
      variant="text"
      class="privacy-toggle"
      color="primary"
      @click="dialog = true"
    >
      Privacy Policy
    </v-btn>

<!-- Privacy Policy Dialog -->
<v-dialog v-model="dialog" width="80%" scrollable persistent>
  <v-card class="rounded-2xl p-6 bg-white text-gray-800">
    
    <!-- Header -->
    <v-card-title class="text-2xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-red-500 to-yellow-400">
      YOUTH Privacy Policy & User Agreement
    </v-card-title>

    <v-divider class="my-4" />

    <!-- Scrollable Content -->
    <v-card-text class="max-h-[70vh] px-10 overflow-y-auto space-y-6 text-base">
      <section>
        <h2 class="text-lg font-semibold text-gray-900">Consent and Acceptance</h2>
        <p>
          By using the YOUTH Platform, you agree to the terms of this Agreement and our handling of your Personal Data in accordance with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Collection</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>For SK Officials: name, email, contact number, profile photo, position, birthday, motto, and term duration.</li>
          <li>For Youth Users: system interaction data.</li>
          <li>For all users: browser info, IP address, and logs for security.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Purpose of Data Use</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>To display SK profiles for transparency.</li>
          <li>To generate governance and project reports.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Retention & Security</h2>
        <p>
          Your data is securely stored and retained only as long as necessary for documentation and governance purposes.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Data Sharing</h2>
        <p>
          Data may be shared only with authorized entities such as LGUs, YOUTH Platform Dev Team, or legal authorities if required. Your data is never sold.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Your Rights</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>Right to be informed, access, correct, or delete your data.</li>
          <li>Right to object or withdraw consent under lawful conditions.</li>
        </ul>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Limitation of Liability</h2>
        <p>
          YOUTH is not liable for data loss due to user negligence, unauthorized access, or technical failures beyond our control.
        </p>
      </section>

      <v-divider class="pa-5"></v-divider>

      <section>
        <h2 class="text-lg font-semibold text-gray-900">Governing Law</h2>
        <p>
          This Agreement is governed by the laws of the Republic of the Philippines and any disputes shall be settled in the courts of Iriga City.
        </p>
      </section>

    </v-card-text>

    <!-- Close Button -->
    <v-card-actions class="mt-4 justify-end">
      <v-btn color="primary" variant="elevated" @click="dialog = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>


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
    const theme = useTheme()
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
        return;
      }
  
      this.loading = true;
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      const api_base = 'http://localhost/youth/app/api.php';
  
      await $.ajax({
        url: `${api_base}?e=sk-official&a=login`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        data: {
          identifier: this.username,
          password: this.password,
          remember: true
        },
        headers: { 'X-CSRF-Token': csrfToken },
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
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-position: center;
  background-attachment: fixed;
  gap: 1.5rem;
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

.primary {
  cursor: pointer;
  color: #fff;
  text-decoration: underline;
}

.privacy-toggle:hover {
  opacity: 0.8;
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
  color: #fff;
}

.v-text-field .v-field__outline {
  border-color: rgba(255, 255, 255, 0.5) !important;
}

.v-text-field .v-field-label {
  color: rgba(255, 255, 255, 0.7) !important;
}

.dialog {
  padding: 1rem;
}

.dialog {
  padding: 1rem;
}
</style>
