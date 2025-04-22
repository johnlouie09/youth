<template>
    <v-card class="official-card" elevation="4">
      <v-card-title class="text-center text-h5 pb-4 border-bottom">
        {{ official.position.toUpperCase() }}
      </v-card-title>
      <v-card-text class="d-flex flex-column align-center mt-4">
        <v-avatar
          :image="official.img ? ($store.getters.base + '/OfficialImages/' + official.img) : '/OfficialImages/no-avatar.png'"
          alt="Official Img" 
          size="150"
          cover
        ></v-avatar>
        <h3 class="text-h6 font-weight-medium mt-2">{{ official.full_name }}</h3>
        <!-- Only show buttons if position is not SK Chairperson -->
        <div class="d-flex gap-5">
          <v-btn color="primary" variant="outlined" class="mt-3" @click="toEditingOfficial(official)">
            EDIT
          </v-btn>
          <v-btn v-if="official.position !== 'SK Chairperson'" color="error" variant="outlined" class="mt-3" @click="confirmDelete(official.id)">
            DELETE
          </v-btn>
        </div>
      </v-card-text>
    </v-card>
    <Dialogs></Dialogs>
  </template>
  
  <script>
  import Dialogs from '@/components/dialogs/Dialogs.vue';
  import $ from 'jquery';
  export default {
    props: {
      official: Object
    },
    components: {
      Dialogs
    },
    emits: ['fetchInfo'],
    methods: {
      toEditingOfficial(official) {
        this.$router.replace({ name: 'admin-edit-official', params: { officialSlug: official.slug }});
      },
      // Confirm deletion using the Vuex dialog module
      confirmDelete(officialId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Official',
          prompt: 'Are you sure you want to delete this official?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteOfficial(officialId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },
      // Delete official via AJAX
      deleteOfficial(officialId) {
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=deleteOfficial`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: { id: officialId },
          success: (data) => {
            console.log("Official deleted successfully", data);
            // Notify parent to refresh data
            this.$emit('fetchInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting official:", textStatus, errorThrown);
          }
        });
      }
    }
  };
  </script>
  
  <style scoped>
  .official-card {
    width: 100%;
    min-width: 300px;
    max-width: 400px;
    padding: 16px;
    border-radius: 12px;
  }
  .border-bottom {
    border-bottom: 5px solid rgba(55, 114, 255, 0.6);
    padding-bottom: 1rem;
  }
  </style>
  