<template>
  <v-sheet class="nav-main" v-if="!shouldHideNav" elevation="10">
    <div class="logo relative">
      <img class="barangay-logo" :src="$store.getters['base'] + '/Group.svg'" alt="Barangay Logo">
      <img class="logo-name" :src="$store.getters['base'] + '/youth-name.svg'" alt="Youth Name">
    </div>

    <ul>
      <v-btn 
        v-for="view in views" 
        :key="view.to" 
        :to="view.to"
        @click="navigate(view.to)" 
        :class="[view.class, { active: isActive(view.to) }]"
      >
        {{ view.name.toUpperCase() }}
      </v-btn>
    </ul>

    <ThemeSwitcher />
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
        { name: "Home", to: "/", class: "view home" },
        { name: "Contact", to: "/contact", class: "view contact" },
        { name: "About", to: "/about", class: "view about" }
      ]
    };
  },
  computed: {
    shouldHideNav() {
      return this.$route.path.startsWith('/admin') || this.$route.path === '/login' || this.$route.path === '/youth-login';
    }
  },
  methods: {
  isActive(path) {
    return this.$route.path === path;
  },
  navigate(routePath) {
    this.$router.push({ path: routePath })
      .catch((err) => {
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
  padding: 0px 4rem;
  overflow: hidden;
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
  display: flex;
  justify-content: flex-end;
  align-items: center;
  font-weight: bold;
  gap: 3rem;
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
