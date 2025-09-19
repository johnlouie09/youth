<template>
  <v-container
    fluid
    class="login-container"
    :style="{ backgroundImage }"
  >
    <v-card class="login-card" elevation="20">
      <!-- Logo -->
      <div class="logo-container">
        <v-img src="/public/Flogo.svg" max-width="300" class="mx-auto mb-3" />
      </div>

      <!-- Form -->
      <v-form @submit.prevent="handleSubmit">
        <v-text-field
          v-model="username"
          label="Username"
          prepend-inner-icon="mdi-account"
          variant="outlined"
          density="comfortable"
          :error-messages="usernameError"
          :disabled="loading"
        />
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

        <v-btn size="large" block color="primary" type="submit" :loading="loading">
          Log In
        </v-btn>

        <div class="reqErr" v-if="requestError">
          {{ requestError.toUpperCase() }}
        </div>
      </v-form>

      <!-- OAuth buttons -->
      <div class="h-auto d-flex flex-col ga-2 py-5">
        <v-btn size="large">
          <div class="d-flex justify-center items-center ga-3">
            <v-avatar size="25" :image="$store.getters['base'] + 'public/fb.png'" />
            <span class="text-sm">Continue with Facebook</span>
          </div>
        </v-btn>

        <v-btn size="large" @click="loginWithGoogle">
          <div class="d-flex justify-center items-center ga-3">
            <v-avatar size="30" :image="$store.getters['base'] + 'public/google_logo.svg'" />
            <span class="text-sm">Continue with Google</span>
          </div>
        </v-btn>
      </div>
    </v-card>
  </v-container>
</template>

<script>
import $ from "jquery";
import debounce from "lodash/debounce";

export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
      loading: false,
      usernameError: "",
      passwordError: "",
      requestError: "",
      backgroundImage: "", // set dynamically in mounted
    };
  },
  mounted() {
    // 🎨 Background gradient based on theme
    const isDark = this.$vuetify.theme.global.current.dark;
    this.backgroundImage = isDark
      ? "linear-gradient(45deg, #363636, #0e0e0e, #363636, #0e0e0e)"
      : "linear-gradient(45deg, #f0f0f0, #ffffff)";

    // 🎯 Handle OAuth redirect with ?code=...
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    if (code) {
      $.ajax({
        url: `${this.$store.getters["api_base"]}?e=auth&a=process`,
        type: "POST",
        xhrFields: { withCredentials: true },
        headers: {
          "X-CSRF-Token": document.querySelector("meta[name='csrf-token']").content,
        },
        data: { code },
        success: (res) => {
          if (res.success) {
            this.$store.commit("auth/setUser", res.data);
            const barangaySlug = res?.data?.barangay?.slug;
            if (barangaySlug) {
              this.$router.replace({ name: "admin-dashboard", params: { barangaySlug } });
            } else {
              this.$router.replace({ name: "admin-dashboard" });
            }
          } else {
            console.error("OAuth failed:", res);
          }
        },
        error: (xhr, status, err) => {
          console.error("OAuth request error:", err);
        },
      });
    }
  },
  methods: {
    loginWithGoogle() {
      const clientId =
        "1096632843138-q7q1pg5qil4699vg1bhfecsjmjcat6gj.apps.googleusercontent.com";
      const redirectUri = "http://localhost:5173/login";
      const scope = "openid email profile";
      const responseType = "code";

      const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${encodeURIComponent(
        redirectUri
      )}&response_type=${responseType}&scope=${encodeURIComponent(scope)}`;

      window.location.href = authUrl;
    },

    validateForm() {
      let valid = true;
      this.usernameError = "";
      this.passwordError = "";

      if (!this.username.trim()) {
        this.usernameError = "Username is required";
        valid = false;
      }
      if (!this.password.trim()) {
        this.passwordError = "Password is required";
        valid = false;
      }
      return valid;
    },

    handleSubmit: debounce(function () {
      if (!this.validateForm()) return;

      this.loading = true;
      this.requestError = "";
      const csrfToken = document.querySelector("meta[name='csrf-token']")?.content || "";

      if (!csrfToken) {
        this.requestError = "CSRF token missing. Please refresh the page.";
        this.loading = false;
        return;
      }

      $.ajax({
        url: `${this.$store.getters["api_base"]}?e=auth&a=login`,
        type: "POST",
        xhrFields: { withCredentials: true },
        data: {
          identifier: this.username,
          password: this.password,
        },
        headers: { "X-CSRF-Token": csrfToken },
        success: (data) => {
          this.$store.commit("auth/setUser", data.data);
          const barangaySlug = data?.data?.barangay?.slug;
          if (!barangaySlug) {
            this.requestError = "Invalid response from server. Missing barangay slug.";
            return;
          }
          this.$router.replace({
            name: "admin-dashboard",
            params: { barangaySlug },
          });
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
        },
      });
    }, 300),
  },
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
    gap: 1rem;
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
