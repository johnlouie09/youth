<template>
  <v-sheet class="nav-main" v-if="!shouldHideNav">
    <div class="logo">
      <img class="barangay-logo" src="../../../public/group.svg" alt="Barangay Logo">
      <img class="logo-name" src="../../../public/youth-name.svg">
    </div>

    <ul>
      <RouterLink
        v-for="view in views"
        :to="view.to"
        :class="[view.class, { active: isActive(view.to) }]"
        :key="view.to"
      >
        {{ view.name.toUpperCase() }}
      </RouterLink>
      <!-- New "Send a Message" item, shown only if current route is "/barangay" -->
      <RouterLink
        v-if="route.path === '/barangay'"
        to="/barangay/send-message"
        class="view message"
      >
        <v-icon>mdi-message</v-icon>
      </RouterLink>
      <ThemeSwitcher></ThemeSwitcher>
    </ul>
  </v-sheet>
</template>

<script setup>
import { computed, reactive } from 'vue';
import { useRoute } from 'vue-router';
import ThemeSwitcher from '../ThemeSwitcher.vue';

const route = useRoute();

// Compute whether to hide the navbar if the route is an admin route or the login route.
const shouldHideNav = computed(() => route.path.startsWith('/admin') || route.path === '/login');

const views = reactive([
  { name: "Home", to: "/home", class: "view home" },
  { name: "About", to: "/about", class: "view about" },
  { name: "Contact", to: "/contact", class: "view contact" }
]);

const isActive = (to) => {
  return route.path === to;
};
</script>

<style scoped>
.nav-main {
  position: fixed;
  top: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000; /* Ensure it stays on top */
  width: 60%;
  height: 7vh;
  color: #848484;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 1rem;
  padding: 0px 2rem;
  overflow: hidden;
  /* Animation: from 0 width to 60% over 1 second */
  animation: expandWidth 2s ease-out forwards;
}

@keyframes expandWidth {
  0% {
    width: 0%;
  }
  100% {
    width: 60%;
  }
}

@keyframes infiniteRotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.logo {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  gap: 1rem;
  height: 10%;
}

.barangay-logo {
  height: 3vh;
}

.logo-name {
  height: 1.5vh;
}

ul {
  width: 60%;
  display: flex;
  justify-content: space-around;
  align-items: center;
  font-weight: bold;
}

.view {
  font-size: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: color 0.3s ease, border-bottom 0.3s ease;
}

.view:hover {
  color: #3772FF;
}

/* Active state */
.active {
  border: 1px solid #3772FF;
  color: #3772FF;
}

/* Style for the new send-message item */
.message {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
