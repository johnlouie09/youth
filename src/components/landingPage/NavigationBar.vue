<template>
  <v-sheet class="nav-main" v-if="!shouldHideNav" elevation="10">
    <div class="logo">
      <img class="barangay-logo" src="../../../public/group.svg" alt="Barangay Logo">
      <img class="logo-name" src="../../../public/youth-name.svg" alt="Youth Name">
    </div>

    <ul>
      <li 
        v-for="view in views" 
        :key="view.to" 
        @click="navigate(view.to)" 
        :class="[view.class, { active: isActive(view.to) }]"
      >
        {{ view.name.toUpperCase() }}
      </li>
      <RouterLink
        v-if="$route.path === '/barangay'"
        to="/barangay/send-message"
        class="view message"
      >
        <v-icon>mdi-message</v-icon>
      </RouterLink>
      <ThemeSwitcher />
    </ul>
  </v-sheet>
</template>

<script>
import ThemeSwitcher from '../ThemeSwitcher.vue';

export default {
  name: 'NavMain',
  components: { ThemeSwitcher },
  data() {
    return {
      views: [
        { name: "Home", to: "home", class: "view home" },
        { name: "About", to: "about", class: "view about" },
        { name: "Contact", to: "contact", class: "view contact" }
      ]
    };
  },
  computed: {
    shouldHideNav() {
      return this.$route.path.startsWith('/admin') || this.$route.path === '/login';
    }
  },
  methods: {
    isActive(routeName) {
      return this.$route.name === routeName;
    },
    navigate(routeName) {
      this.$router.push({ name: routeName })
        .then(() => {
          window.location.reload();
        })
        .catch((err) => {
          // Optionally catch NavigationDuplicated errors.
          if (err.name !== 'NavigationDuplicated') {
            console.error(err);
          }
        });
    }
  }
};
</script>

<style scoped>
.nav-main {
  position: fixed;
  top: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  width: 60%;
  height: 7vh;
  color: #848484;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 1rem;
  padding: 0px 2rem;
  overflow: hidden;
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

.logo {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  gap: 0.5rem;
}

.barangay-logo {
  height: 3.5vh;
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
  cursor: pointer;
}

.view:hover {
  color: #3772FF;
}

.active {
  border: 1px solid #3772FF;
  color: #3772FF;
}

.message {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
