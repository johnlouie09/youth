<template>
  <v-sheet class="nav-main" v-if="!shouldHideNav" elevation="10">
    <ul class="logo d-flex flex-row items-center gap-3" @click="navigate('/')">
      <v-avatar :image="$store.getters.base + 'public/Group.svg'"></v-avatar> 
      <img style="height: 1.5vh;" src="../../../public/youth-name.svg"></img>
    </ul>

    <ul class="w-[50%] d-flex justify-evenly items-center ">
      <v-divider vertical></v-divider>
      <v-btn 
        v-for="view in views" 
        :key="view.to" 
        @click="navigate(view.to)" 
        class="custom-btn text-xl font-bold pa-3 px-10 h-auto"
        :class="[view.class, { 'active-btn': isActive(view.to), 'custom-btn': true }]"
      >
        <span class="overlay-titles">{{ view.name.toUpperCase() }}</span>
      </v-btn>
      <v-divider vertical></v-divider>
    </ul>



    <v-sheet class="d-flex flex-row justify-center items-center gap-5">
      <v-btn class="text-xl font-bold pa-3 px-10 h-auto elevation-0" @click="navigate('/login')">
        Log in
        <v-icon class="ml-2">
          mdi-login-variant
        </v-icon>
      </v-btn>
    </v-sheet>
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
  height: 8vh;
  width: 90%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 2rem;
  padding: 0px 4rem;
}

.view {
  font-size: .8rem;
  padding: 0rem 3rem;
  border-radius: 0.5rem;
  transition: color 0.3s ease, border-bottom 0.3s ease;
  cursor: pointer;
}
</style>
