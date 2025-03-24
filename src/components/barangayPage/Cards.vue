<template>
    <v-container class="main-barangay-officials elevation-20">
        <v-card-title class="font-bold">
        SANGGUNIANG KABATAAN OFFICIALS
        </v-card-title>

        <div class="officials">
            <!-- SK Chairperson -->
            <OfficialCard 
                :officialProps="skChairperson || {}" 
                class="custom-card chairperson-card "
            ></OfficialCard>

            <!-- SK Members Slider -->
            <div class="members">
                <v-slide-group selected-class="bg-success" show-arrows class="pa-4">
                <v-slide-group-item
                    v-for="(skMember, index) in skMembers"
                    :key="index"
                    v-slot="{ selectedClass }"
                >
                    <OfficialCard 
                    :class="['ml-5', 'mr-5', selectedClass, 'members-card', 'custom-card']" 
                    :officialProps="skMember || {}"
                    ></OfficialCard>
                </v-slide-group-item>
                </v-slide-group>
            </div>
        </div>
    </v-container>
</template>
  
  
  <script>
import OfficialCard from './OfficialCard.vue';
  import $ from 'jquery';
  
  export default {
    name: 'Cards',
    props: {
      barangayId: {
        type: Number,
        required: true
      }
    },
    components: {
      OfficialCard
    },
    data() {
      return {
        // Assign the prop to a local data property for ease of use
        myBarangayId: this.barangayId,
        skChairperson: {},
        skMembers: {}
      };
    },
    methods: {
      async fetchSkOfficials() {
        const api_base = 'http://localhost/youth/app/api.php';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        await $.ajax({
          url: `${api_base}?e=barangay&a=sk-officials`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': csrfToken },
          // Use the local data property myBarangayId here
          data: { barangayId: this.myBarangayId },
          success: (data) => {
            this.skChairperson = data.data.skChairman;
            this.skMembers = data.data.skMembers;
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
            let errorMsg = "An error occurred while processing your request.";
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
              errorMsg = jqXHR.responseJSON.message;
            } else if (jqXHR.responseText) {
              errorMsg = jqXHR.responseText;
            }
          },
          complete: () => {
            // Optional: handle any completion logic
          }
        });
      }
    },
    created() {
      this.fetchSkOfficials();
    },
    watch: {
      // Watch the prop and update the local data if it changes
      barangayId(newVal) {
        this.myBarangayId = newVal;
        this.fetchSkOfficials();
      }
    }
  };
  </script>
  
  <style scoped>
  @import "@/assets/cards.css";
  @import "@/assets/fontEffects.css";
  
  .main-barangay-officials {
    width: 100%;
    padding: 5rem 5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 2rem;
    border-radius: 1rem;
  }
  
  .officials {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    gap: 5rem;
    width: 100%;
  }
  
  .members {
    width: 70%;
    height: 35vh;
    display: flex;
    justify-content: center;
  }
  
  .font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 900;
    font-size: 1.5rem;
  }
  </style>
  