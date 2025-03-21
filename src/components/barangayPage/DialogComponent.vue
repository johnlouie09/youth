<template>
    <v-dialog v-model="isDialogOpen" max-width="900px">
        <v-card style="border-radius: 20px;" border="primary lg">
            <v-card-title class="d-flex align-center">
                <v-avatar size="200">
                    <img src="/Sangguniang_Kabataan_logo.svg" alt="Profile Picture">
                </v-avatar>
                <div class="ml-3 text-wrap">
                    <span class="headline font-weight-bold">{{ officialInfos.personalInfo.position }}</span>
                    <br>
                    <v-card-title class="d-block text-grey motto-text">
                        {{ officialInfos.personalInfo.motto }}
                    </v-card-title>
                </div>
            </v-card-title>
            <v-divider class="mt-3"></v-divider>

            <v-card-text style="max-height: 400px; overflow-y: auto;">
                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: center; padding: 16px;">
                        <v-card-title class="text-center">
                            <v-icon class="mr-2">mdi-account</v-icon>PROFILE INFORMATION
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
                        <v-container>
                            <v-row justify="center" align="center">
                                <v-col cols="6" class="text-left">
                                    <p><strong>Name:</strong> {{ officialInfos.personalInfo.full_name }}</p>
                                    <p><strong>Email:</strong> {{ officialInfos.personalInfo.email }}</p>
                                </v-col>
                                <v-col cols="4" class="text-left">
                                    <p><strong>SK Position:</strong> {{ officialInfos.personalInfo.position }}</p>
                                    <p><strong>Birthday:</strong> {{ officialInfos.personalInfo.birthday }}</p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: start; padding: 16px;">
                        <v-card-title style="text-align: center">
                            <v-icon class="mr-2">mdi-school</v-icon>EDUCATIONAL BACKGROUNDS
                        </v-card-title>
                        <v-divider class="border-opacity-25" color="info"></v-divider>
                        <v-card-text class="bg-surface">
                            <v-timeline side="end">
                                <v-timeline-item v-for="educationalBackground in officialInfos.educationalBackgrounds" color="primary" small>
                                    <v-card>
                                        <v-card-title>{{ educationalBackground.start_year }} - {{ educationalBackground.end_year }}</v-card-title>
                                        <v-card-subtitle>{{ educationalBackground.school_name }}</v-card-subtitle>
                                        <v-card-text>{{ educationalBackground.course }}</v-card-text>
                                    </v-card>
                                </v-timeline-item>
                            </v-timeline>
                        </v-card-text>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" class="profile-sheet">
                        <v-card-title class="text-center">
                            <v-icon class="mr-2">mdi-plus-box</v-icon>OTHER INFORMATIONS
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
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
                </div>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue" @click="closeDialog">Close</v-btn>
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
    }
  },
  data() {
    return {
      officialInfos: {},
      profileData: [] // Define the profileData property to fix the warning.
    };
  },
  methods: {
    closeDialog() {
      this.isDialogOpen = false;
      this.$store.commit('viewOfficial/setViewOfficialOpenDialog', false);
    },
    openDialog(official) {
      console.log("Opening dialog for:", official);
    },
    async fetchEducationalBackgrounds(id) {
      const api_base = 'http://localhost/youth/app/api.php';
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      await $.ajax({
        url: `${api_base}?e=sk-official&a=sk-educations`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': csrfToken },
        data: { skOfficialId: id },
        success: (data) => {
          console.log(data);
          this.officialInfos.educationalBackgrounds = data.data.educations;
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
  },
  created() {
    this.officialInfos = this.$store.getters['viewOfficial/getViewOfficial'];
    if (
      this.officialInfos &&
      this.officialInfos.personalInfo &&
      this.officialInfos.personalInfo.id
    ) {
      this.fetchEducationalBackgrounds(this.officialInfos.personalInfo.id);
    }
  },
  watch: {
    'officialInfos.personalInfo.id'(newId) {
      if (newId) {
        this.fetchEducationalBackgrounds(newId);
      }
    }
  }
};
</script>

<style scoped>
/* Your styles here */
</style>
