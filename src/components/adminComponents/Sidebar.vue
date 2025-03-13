<template>
    <v-navigation-drawer v-model="drawer" app width="280" class="pa-3 pt-7 pb-7">
      <!-- Logo and Barangay Name -->
      <v-list-item class="logo-container">
        <template v-slot:prepend>
          <v-avatar size="45">
            <v-img :src="`${$store.getters['base']}Group.svg`" alt="Barangay Logo"></v-img>
          </v-avatar>
        </template>
        <v-list-item-content>
          <v-list-item-title>BARANGAY</v-list-item-title>
          <v-list-item-subtitle>{{ barangaySlug.toUpperCase() }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
  
      <!-- Navigation Menu -->
      <v-list density="compact" nav>
        <v-list-item
          v-for="menuObj in menuObjs"
          :key="menuObj.menuName"
          @click="navigate(menuObj.to)"
          active-class="active"
          density="compact"
          class="mb-6"
        >
          <template v-slot:prepend>
            <v-icon>{{ menuObj.icon }}</v-icon>
          </template>
          <v-list-item-title style="font-size: 1rem;">{{ menuObj.menuName }}</v-list-item-title>
        </v-list-item>
      </v-list>
  
      <v-spacer></v-spacer>
  
      <!-- Centered Theme Switcher -->
      <div class="theme-container">
        <ThemeSwitcher />
      </div>
  
      <!-- Logout Button at the Bottom Center -->
      <v-list-item class="logout-container">
        <v-btn block color="error" variant="outlined" @click="logout">
          <v-icon left>mdi-logout</v-icon>
          <span>LOG OUT</span>
        </v-btn>
      </v-list-item>
    </v-navigation-drawer>
  </template>
  
  <script>
  import ThemeSwitcher from '../ThemeSwitcher.vue';
  import $ from 'jquery';
  
  export default {
    components: { ThemeSwitcher },
    data() {
      return {
        drawer: true,
        api_base: (import.meta.env.DEV ? 'http://localhost/youth' : '/youth') + '/app/api.php',
      };
    },
    computed: {
      barangaySlug() {
        const user = this.$store.getters['auth/getUser'];
        return user && user.barangay ? user.barangay.slug : 'default-slug';
      },
      // Build the menu objects dynamically using the slug from the URL.
      menuObjs() {
          return [
          { menuName: "Dashboard", icon: "mdi-view-dashboard", to: `/admin/${this.barangaySlug}/dashboard` },
          { menuName: "Officials", icon: "mdi-account-group", to: `/admin/${this.barangaySlug}/officials` },
          { menuName: "Announcements", icon: "mdi-bullhorn", to: `/admin/${this.barangaySlug}/announcements` },
          { menuName: "Achievements", icon: "mdi-trophy", to: `/admin/${this.barangaySlug}/achievements` },
          { menuName: "Settings and Profile", icon: "mdi-cog", to: `/admin/${this.barangaySlug}/settings` },
          { menuName: "Notices", icon: "mdi-bell", to: `/admin/${this.barangaySlug}/notices` }
          ];
      }
    },
    methods: {
      // Use router.push so that you can manipulate the URL dynamically
      navigate(path) {
        this.$router.push(path);
      },
      logout() {
        $.ajax({
            type: 'POST', xhrFields: { withCredentials: true },
            url : `${this.api_base}?e=sk-official&a=logout`,
            data: {
              username: this.$store.getters['auth/getUser'].sk_official.username

            },
            success: () => {
              this.$store.commit('auth/setUser', null);
              this.$router.replace({ name: 'login'});
            },
            error: (error) => {
                console.error("Logout error: ", error);
            }
        });
      }
    }
  };
  </script>
  
  <style scoped>
  .active {
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  .logo-container {
    display: flex;
    align-items: center;
    padding: 16px;
    margin-bottom: 5%;
  }
  
  .v-navigation-drawer {
    display: flex;
    flex-direction: column;
    transition: width 0.3s;
  }
  
  /* Centering the Theme Switcher */
  .theme-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 16px;
  }
  
  /* Logout Button at the Bottom */
  .logout-container {
    position: absolute;
    bottom: 3rem;
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 0 16px;
  }
  
  @media (max-width: 600px) {
    .v-navigation-drawer {
      width: 56px !important;
    }
  }
  </style>
  