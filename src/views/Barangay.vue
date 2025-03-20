<script>
import { useTheme } from 'vuetify';
import Announcements from '@/components/barangayPage/Announcements.vue';
import Cards from '@/components/barangayPage/Cards.vue';
import Achievements from '@/components/barangayPage/Achievements.vue';
import DialogComponent from '@/components/barangayPage/DialogComponent.vue';

import $ from 'jquery';

export default {
  name: 'Barangay',
  components: {
    Announcements,
    Cards,
    Achievements,
    DialogComponent
  },
  data() {
    return {
      barangaySlug: this.$route.params.barangaySlug,
      barangayId: this.$route.params.barangayId,
      barangayInfo: "",
      barangay: {
        announcements: [{}],
      }
    };
  },
  methods: {
    async fetchBarangayInfo() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      const api_base = 'http://localhost/youth/app/api.php';
      await $.ajax({
          url: `${api_base}?e=barangay&a=barangayInfo`,
          type: 'POST',
          xhrFields: {
              withCredentials: true
          },
          headers: {
              'X-CSRF-Token': csrfToken
          },
          data: {
              barangayId: this.barangayId
          },
          success: (data) => {
              this.barangayInfo = data.data.barangayInfo;
          },
          error: (jqXHR, textStatus, errorThrown) => {
              console.error("Error:", textStatus, errorThrown);
          },
          complete: () => {
          }
      });
    }
  },
  setup() {
    const theme = useTheme();
    return { theme };
  },
  computed: {
    themeName() {
      return this.theme.global.name.value;
    },
    isDark() {
      return this.theme.current.value.dark;
    }
  },
  created() {
    this.fetchBarangayInfo();
  },
  watch: {
    '$route.params': {
      handler(newParams) {
        this.barangaySlug = newParams.barangaySlug;
        this.barangayId = newParams.barangayId;
      },
      deep: true
    }
  }
};
</script>

<template>
  <v-container
    :theme="themeName"
    fluid
    :class="['barangay-main', { 'dark-gradient': isDark }]"
  >
    <div class="dp-barangay elevation-15" 
    :style="{
      'background-image': `url(/public/barangayHall/${barangayInfo.img})`
      
      }">
      <img class="logo w-80 h-auto" src="/Logoseal.svg" alt="logo" />
      <h1>
        BARANGAY {{ barangayInfo.name.toUpperCase() }}
      </h1>
      <img class="logo w-80 h-auto" src="/Logoseal.svg" alt="logo" />
    </div>
    <Announcements/>
    <Cards/>
    <Achievements></Achievements>
    <DialogComponent></DialogComponent>
  </v-container>
</template>

<style scoped>
.barangay-main {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 10rem;
  margin: 0;
  padding: 0;
  padding-bottom: 5rem;
  background-position: center;
  background-attachment: fixed;
  background-image: linear-gradient(
    45deg,
    rgb(245, 238, 92),
    rgb(255, 255, 255),
    rgba(130, 169, 252, 0.986),
    rgb(255, 255, 255),
    rgb(252, 84, 95)
  );
}

.dark-gradient {
  background-image: linear-gradient(
    45deg,
    #363636,
    #0e0e0e,
    #363636,
    #0e0e0e
  );
}

.dp-barangay {
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 45vh;
  border-radius: 0 0 2rem 2rem;
  background-position: center;
  background-repeat: repeat;
  background-size: auto;
  overflow: hidden;
}

.dp-barangay::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0.5;
  z-index: 1;
}

.dp-barangay h1 {
  will-change: transform, opacity;
  font-size: 3rem;
  font-weight: 900;
  background: linear-gradient(
    45deg,
    #0533a0,
    #ffffff,
    #DF2935,
    #d4d4d4,
    #FDCA40,
    #d4d4d4
  );
  background: linear-gradient(to left, #3772FF, #DF2935, #fffefe, #FDCA40, #3772FF);
  background-size: 200% 100%;
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: animate-gradient 2s linear infinite;
}

.dp-barangay > * {
  z-index: 2;
}

@keyframes animate-gradient {
  from {
    background-position: 200% 50%;
  }
  to {
    background-position: 0% 50%;
  }
}
</style>
