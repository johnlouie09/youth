<template>
  <v-dialog v-model="isDialogOpen" max-width="900px" height="90vh" persistent>
    <v-card style="border-radius: 1rem;" border="primary lg">
      <v-card-title class="d-flex flex-col align-center justify-center pa-10 ga-5">
        <v-avatar size="150">
          <img src="/Sangguniang_Kabataan_logo.svg" alt="Profile Picture">
        </v-avatar>
        <div class="text-wrap text-center">
          <h2 class="text-xl font-black uppercase">
            {{ officialInfos.personalInfo?.full_name || '' }}
          </h2>
          <span class="text-base font-bold pa-0 w-full">
            {{ officialInfos.personalInfo?.position.toUpperCase() || '' }}
          </span>  
        </div>
      </v-card-title>

      <!-- Icon Tab Bar with active state -->
      <v-sheet class="d-flex justify-evenly">
        <v-btn 
          icon 
          :class="{ 'active-tab': activeTab === 'profile' }" 
          @click="activeTab = 'profile'">
          <v-icon>mdi-account</v-icon>
        </v-btn>
        <v-btn 
          icon 
          :class="{ 'active-tab': activeTab === 'education' }" 
          @click="activeTab = 'education'">
          <v-icon>mdi-school</v-icon>
        </v-btn>
        <v-btn 
          icon 
          :class="{ 'active-tab': activeTab === 'achievements' }" 
          @click="activeTab = 'achievements'">
          <v-icon>mdi-trophy</v-icon>
        </v-btn>
        <v-btn 
          icon 
          :class="{ 'active-tab': activeTab === 'other' }" 
          @click="activeTab = 'other'">
          <v-icon>mdi-plus-box</v-icon>
        </v-btn>
      </v-sheet>

      <v-divider class="mt-5"></v-divider>

      <!-- Content Sections -->
      <v-container style="overflow-y: auto; display: flex; justify-content: center; height: 100%; padding: 0;">
        <!-- Profile Information Section -->
        <v-sheet 
          v-if="activeTab === 'profile'" class="w-full rounded-lg overflow-auto">
          <v-card-title class="text-center sticky top-0 pa-0 pt-5 bg-inherit">
            <v-icon class="mr-2">mdi-account</v-icon>PROFILE INFORMATION
            <v-divider class="mt-5"></v-divider>
          </v-card-title>
          
          <v-container class="d-flex justify-center">
            <v-row justify="center" align="center">
              <v-col cols="6" class="text-left">
                <p><strong>Email:</strong> {{ officialInfos.personalInfo?.email || '' }}</p>
              </v-col>
              <v-col cols="4" class="text-left">
                <p><strong>Birthday:</strong> {{ officialInfos.personalInfo?.birthday || '' }}</p>
              </v-col>
            </v-row>

            <p class="d-block w-[70%] text-center text-xl text-grey font-italic motto-text absolute bottom-0 py-15">"{{ officialInfos.personalInfo?.motto }}"</p>
          </v-container>
        </v-sheet>

        <!-- Educational Backgrounds Section -->
        <v-sheet v-if="activeTab === 'education'" class="overflow-auto w-full">
          <v-card-title class="text-center sticky top-0 z-10 pa-0 pt-5 bg-inherit">
            <v-icon class="mr-2">mdi-school</v-icon>EDUCATIONAL BACKGROUNDS
            <v-divider class="mt-5"></v-divider>
          </v-card-title>


          <v-container class="d-flex flex-start justify-center flex-wrap ga-8 py-10">
            <v-card
            v-for="(item, index) in officialInfos.educationalBackgrounds"
            :key="index"
            class="d-flex flex-row justify-start items-center w-[60%] ga-5 rounded-md pa-10"
            elevation="4"
            >
              <v-avatar :image="item.img || '/public/ADNU.png'" size="75"></v-avatar>
              <article class="d-flex flex-col ga-1" >
                  <h2 class="text-lg uppercase font-bold">{{ item.school_name }}</h2>
                  <p class="text-base">{{ item.course }}</p>
                  <h3 class="text-sm">{{ item.start_year }} - {{ item.end_year}}</h3>
              </article>
            </v-card>
          </v-container>
        </v-sheet>

        <!-- Personal Achievements Section -->
        <v-sheet v-if="activeTab === 'achievements'" class="overflow-auto w-full">
          <v-card-title class="text-center sticky top-0 z-10 pa-0 pt-5 bg-inherit">
            <v-icon class="mr-2">mdi-trophy</v-icon>PERSONAL ACHIEVEMENTS
            <v-divider class="mt-5"></v-divider>
          </v-card-title>

          <v-container class="d-flex flex-row flex-wrap justify-evenly items-center ga-10">
            <v-card elevation="5" 
            v-for="(achievement, index) in officialInfos.achievements"  :key="achievement.id"
            class="card w-[35%] rounded-lg d-flex flex-col items-center ga-5 pb-5 "
            >
              <img :src="`/public/achievements/${achievement.img}`" alt="" class="elevation-10">
              
              <article class="d-flex flex-col items-start w-full px-5">
                <h3 class="uppercase text-base font-black">{{ achievement.title }}</h3>
                <h5 class="text-sm font-medium">{{ achievement.subtitle }}</h5>
                <h5 class="text-xs">{{ achievement.date }}</h5>
              </article>
      
            </v-card>
          </v-container>

        </v-sheet>

        <!-- Other Informations Section -->
        <v-sheet 
          v-if="activeTab === 'other'" 
          width="800" 
          elevation="10" 
          class="profile-sheet"
          style="border-radius: .5rem; overflow: auto; text-align: center; width: 100%;">
          <v-card-title class="text-center sticky top-0 z-10 pa-5">
            <v-icon class="mr-2">mdi-plus-box</v-icon>OTHER INFORMATIONS
          </v-card-title>
          <v-divider class="mt-5"></v-divider>
          <v-container>
            <section v-for="(category, index) in profileData" :key="index" class="mb-4">
              <h3 class="font-weight-bold">{{ category.title }}</h3>
              <v-divider class="my-2" color="grey darken-1"></v-divider>
              <ul class="list-none pa-0">
                <li v-for="(item, i) in category.items" :key="i" class="d-flex align-center">
                  <v-icon size="12" class="mr-2">mdi-circle-small</v-icon>
                  {{ item }}
                </li>
              </ul>
            </section>
          </v-container>
        </v-sheet>
      </v-container>

      <!-- Close Button -->
      <v-card-actions class="absolute top-0 right-0 pa-5">
        <v-btn icon color="red" @click="closeDialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import $ from 'jquery';
export default {
  name: "DialogComponent",
  computed: {
    isDialogOpen: {
      get() {
        return this.$store.getters['viewOfficial/getViewOfficialOpenDialog'];
      },
      set(value) {
        this.$store.commit('viewOfficial/setViewOfficialOpenDialog', value);
      }
    },
    // Wrap the store getter in a computed property for reactivity.
    officialStore() {
      return this.$store.getters['viewOfficial/getViewOfficial'];
    }
  },
  data() {
    return {
      officialInfos: {
        personalInfo: {},
        educationalBackgrounds: [],
        achievements: []
      },
      profileData: [], // Initialize profileData to avoid errors.
      activeTab: 'profile' // Default active tab.
    };
  },
  methods: {
    closeDialog() {
      this.isDialogOpen = false;
      this.$store.commit('viewOfficial/setViewOfficialOpenDialog', false);
      this.activeTab = 'profile'
    },
    openDialog(official) {
      console.log("Opening dialog for:", official);
    },
    async fetchOfficialData(slug) {
      const api_base = 'http://localhost/youth/app/api.php';
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      await $.ajax({
        url: `${api_base}?e=sk-official&a=personalInfo`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': csrfToken },
        data: { officialSlug: slug },
        success: (data) => {
          console.log(data);
          this.officialInfos = data.data;
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
        }
      });
    }
  },
  created() {
    this.officialInfos = this.$store.getters['viewOfficial/getViewOfficial'] || {
      personalInfo: {},
      educationalBackgrounds: [],
      achievements: []
    };
    if (
      this.officialInfos &&
      this.officialInfos.personalInfo &&
      this.officialInfos.personalInfo.slug
    ) {
      this.fetchOfficialData(this.officialInfos.personalInfo.slug);
    }
  },
  watch: {
    officialStore: {
      handler(newVal) {
        if (newVal && newVal.personalInfo && newVal.personalInfo.slug) {
          this.fetchOfficialData(newVal.personalInfo.slug);
        }
      },
      deep: true,
      immediate: true
    }
  }
};
</script>

<style scoped>
.active-tab {
  /* Style the active icon button (you can adjust colors, borders, etc.) */
  background-image: linear-gradient(45deg, #004bf9, #f65c66, #ffd45e);
  border-radius: 50%;
}


</style>
