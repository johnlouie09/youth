<template>
    <v-card class="educational-section" elevation="5">
        <v-card-title class="title d-flex align-center justify-center">
            <v-icon class="me-2" size="30">mdi-account-circle</v-icon>
            <h2 class="mb-0">EDUCATIONAL BACKGROUND</h2>
        </v-card-title>

        <div class="educational-cards">
            <v-container class="d-flex flex-row flex-wrap justify-evenly p-5 pt-0 gap-10">
                <v-card
                v-for="(item, index) in educationalBackgrounds"
                :key="index"
                class="card"
                elevation="10"
                @mouseover="hoverIndex = index"
                @mouseleave="hoverIndex = null"
            >
                <div class="educational-details">
                    <v-avatar 
                    :image="(item.school_logo ? ($store.getters.base + 'schoolLogos/' + item.school_logo) : ($store.getters.base + 'schoolLogos/no-avatar.png'))" size="80"></v-avatar>
                    <article>
                        <h2 class="uppercase text-lg font-extrabold">{{ item.school_name }}</h2>
                        <p class="text-base">{{ item.course }}</p>
                        <h3 class="text-sm font-italic">{{ item.start_year }} - {{ item.end_year}}</h3>
                    </article>
                </div>
                
                <transition name="fade">
                    <div v-if="hoverIndex === index" class="educational-card-actions d-flex flex-col justify-center items-center relative right-0 px-5 ga-5">
                        <v-btn color="teal-lighten-1" outlined @click="editEducation(index)">
                        <v-icon left color="black" size="30">mdi-pencil-circle</v-icon>
                        </v-btn>
                        <v-btn color="red-lighten-1" @click="confirmDelete(item.id)" outlined>
                        <v-icon left color="black" size="30" >mdi-delete-circle</v-icon>
                        </v-btn>
                    </div>
                </transition>

                <FormEducational
                    v-if="editingIndex === index"
                    :education="item"
                    :action="'updating'"
                    @close="editingIndex = null"
                    @fetchInfo="handleChildEvent(true)"
                />
                </v-card>
            </v-container>
            
            <!-- Add New Education Button -->
            <v-btn
            class="d-flex items-center justify-center px-10 py-10 text-lg"
            elevation="10"
            @click="showNewEducation = true"
            >
                <v-icon>mdi-plus-circle-outline</v-icon>
                <span class="ml-4">ADD EDUCATION</span>
            </v-btn>
        </div>

        <!-- New Education Dialog -->
        <FormEducational
        v-if="showNewEducation"
        :education="{ sk_official_id: id, education_level_id: 1, education_level_name: 'Junior High School'}"
        :action="'adding'"
        @fetchInfo="handleChildEvent(true)"
        />
    </v-card>
</template>

<script>
import FormEducational from './InputForms/FormEducational.vue';
import $ from 'jquery';

export default {
    props: {
        educations: Object,
        id: Number
    },
    components: {
        FormEducational
    },
    data() {
        return {
            educationalBackgrounds: {},
            editingIndex: null,
            hoverIndex: null,
            showNewEducation: false
        };
    },
    emits: ['fetchOfficialInfo'],
    methods: {
        editEducation(index) {
            this.editingIndex = index;
        },
        
        /**
         * Handles child events by closing the new achievement form
         * and emitting an event to refresh official information.
         */
        handleChildEvent(payload) {
            this.showNewEducation = false;
            this.editingIndex = null;
            this.$emit('fetchOfficialInfo', payload);
        },

              /**
       * Shows a confirmation dialog for deletion and, if confirmed,
       * calls the deleteAchievement method.
       */
      async confirmDelete(educationId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Education',
          prompt: 'Are you sure you want to delete this education?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteEducation(educationId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },

      /**
       * Deletes an education via an AJAX request.
       */
      deleteEducation(educationId) {
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=deleteEducation`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: { id: educationId },
          success: (data) => {
            console.log("Education deleted successfully", data);
            // Emit event to refresh official information
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      }
    },
    watch : {
        educations: {
            immediate: true,
            handler(newVal) {
                this.educationalBackgrounds = { ...newVal }
            },
            deep: true
        }
    }
};
</script>



<style scoped>
.educational-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 75%;
    border-radius: 1rem;
    padding: 2rem 0;
    gap: 2rem;
}

.educational-cards {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;

}

.educational-cards .card {
    position: relative; /* Make the card a positioned element */
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    padding: 2rem;
    gap: .5rem;
    border-radius: .5rem;
    border: 1px solid rgb(75, 75, 75);
    min-width: 60%;
    width: auto;
}

.educational-details {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    gap: 1.5rem;
    align-items: center;
    width: 100%; 
}
</style>
