<script>
import { useTheme } from 'vuetify';
import Announcements from '@/components/barangayPage/Announcements.vue';
import Cards from '@/components/barangayPage/Cards.vue';
import Achievements from '@/components/barangayPage/Achievements.vue';
import DialogComponent from '@/components/barangayPage/DialogComponent.vue';
import FeedbackForm from '@/components/barangayPage/FeedbackForm.vue';
import YouthAccount from '@/components/barangayPage/YouthAccount.vue';
import $ from 'jquery';

export default {
  name: 'Barangay',
  components: {
    Announcements,
    Cards,
    Achievements,
    DialogComponent,
    FeedbackForm,
    YouthAccount
  },
  data() {
    return {
      barangaySlug: this.$route.params.barangaySlug,
      barangayInfo: {},
      showYouthAccount: false,
      dialog: false
    };
  },
  methods: {
    async fetchBarangayInfo() {
      await $.ajax({
        url: `${this.$store.getters['api_base']}?e=barangay&a=barangayInfo`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''},
        data: {
          barangaySlug: this.barangaySlug
        },
        success: (data) => {
          this.barangayInfo = data.data.barangayInfo;
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error:", textStatus, errorThrown);
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
        this.fetchBarangayInfo();
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
    class="d-flex flex-col justify-center items-center gap-[5rem] pa-0 ma-0 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200"
    :class="['barangay-main', { 'dark-gradient': isDark }]"
  >
    <div class="dp-barangay elevation-15" 
         :style="{ 'background-image': `url(/public/barangayHall/${barangayInfo.img})` }">
      <img class="logo w-80 h-auto" :src="`${this.$store.getters['base']}Logoseal.svg`" alt="logo"/>
      <h1>
        BARANGAY {{ barangayInfo.name ? barangayInfo.name.toUpperCase() : '' }}
      </h1>
      <img class="logo w-80 h-auto" :src="`${this.$store.getters['base']}Logoseal.svg`" alt="logo"/>
    </div>
    <Announcements v-if="barangayInfo.id" :barangayId="barangayInfo.id"/>
    <Cards v-if="barangayInfo.id" :barangayId="barangayInfo.id"/>
    <Achievements v-if="barangayInfo.id" :barangayId="barangayInfo.id"/>

    <!-- Supporting Components -->

    <!-- Supporting Components -->
    <DialogComponent/>

    <div class="form-button">
      <v-btn icon @click="dialog = true">
        <v-icon>mdi-account-circle</v-icon>
      </v-btn>

      
      <FeedbackForm :barangayName="barangayInfo.name"></FeedbackForm>
    </div>



  </v-container>

    <v-dialog v-model="dialog" max-width="800px">
        <v-card class="d-flex justify-center items-center pa-15" style="border-radius: 1rem;">
            <h1 class="text-2xl font-extrabold">YOUTH ACCOUNT</h1>

            <div class="w-[90%] d-flex justify-evenly py-10">
              <v-avatar :image='"/public/OfficialImages/no-avatar.png"' size="150">
              </v-avatar>

              <article>
                <v-card-text>NAME: Charles Harvey Gonzaga</v-card-text>
                <v-card-text>Barangay: San Francisco, Iriga City</v-card-text>
                <v-card-text>Email: harveygonzaga222@gmail.com</v-card-text>
              </article>

            </div>

          <v-btn class="d-flex justify-center pa-5 items-center gap-3" color="error" variant="outlined" @click="dialog = false">
            <v-icon>mdi-logout</v-icon>
            <span>LOG OUT</span>
          </v-btn>
                
        </v-card>
    </v-dialog>
</template>

<style scoped>
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
  height: 40vh;
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
  background: linear-gradient(to left, #3772FF, #fffefe, #DF2935, #FDCA40, #3772FF);
  background-size: 200% 100%;
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: animate-gradient 2s linear infinite;
}

.dp-barangay > * {
  z-index: 2;
}

.form-button {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    position: fixed;
    margin: 2rem;
    bottom: 0; /* distance from the bottom */
    right: 0; /* distance from the right */
    z-index: 1000; /* ensures the button stays on top of other elements */
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
