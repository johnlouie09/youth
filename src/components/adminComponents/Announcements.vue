<template>
    <v-container class="announcement-main">
        <h1>ANNOUNCEMENTS</h1>
        <div class="w-full d-flex flex-row flex-wrap justify-center ga-10 items-start">
            <v-card 
            v-for="announcement in announcements" 
            :key="announcement.id"
            class="announcement-card w-[30%] h-[500px] d-flex flex-col justify-start ga-5 pa-8 elevation-10 rounded-xl"
            >
            <v-img 
                :src="announcement.img 
                        ? ($store.getters.base + 'public/announcements/' + announcement.img) 
                        : ($store.getters.base + 'public/announcements/exx.jpg')"
                class="rounded h-[400px]"
                contain
            ></v-img>

            <div class="w-full d-flex justify-center items-center">
                <!-- The button is hidden by default; CSS will reveal it on hover -->
                <v-btn class="delete-btn" color="red-lighten-1" @click="confirmDelete(announcement.id)">DELETE</v-btn>
            </div>
            </v-card>
        </div>


        <v-btn
            class="w-[30%] d-flex items-center justify-center px-10 py-10 text-lg"
            elevation="10"
            >
                <v-icon>mdi-plus-circle-outline</v-icon>
                <span class="ml-4"  @click="triggerFileInput">ADD ACHIEVEMENT</span>
        </v-btn>
    </v-container>

    <input
        ref="fileInput"
        type="file"
        accept="image/*"
        class="hidden"
        @change="handleFileUpload"
    />
</template>
  
<script>
import $ from 'jquery';
export default {
    data() {
        return {
            announcements: {},
            file: null,
            newAnnouncement: {}
        };
    },
    methods: {
        // Trigger the hidden file input
        triggerFileInput() {
        this.$refs.fileInput.click();
        },
        // Handle file upload and create a preview
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.file = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                this.filePreview = e.target.result;
                // Store the filename for later use
                this.newAnnouncement.img = file.name;
                };
                reader.readAsDataURL(file);
            }
            this.addAnnouncement();
        },
              /**
       * Shows a confirmation dialog for deletion and, if confirmed,
       * calls the deleteAchievement method.
       */
      async confirmDelete(announcementId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Announcement',
          prompt: 'Are you sure you want to delete this announcement?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteAnnouncement(announcementId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },

      /**
       * Deletes an announcement via an AJAX request.
       */
      deleteAnnouncement(announcementId) {
        $.ajax({
            url: `${this.$store.getters['api_base']}?e=barangay&a=delete-announcement`,
            type: 'POST',
            xhrFields: { withCredentials: true },
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            },
            data: { id: announcementId },
            success: (data) => {
                this.fetchBarangayAnnouncements();
                console.log("Announcement deleted successfully", data);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error deleting achievement:", textStatus, errorThrown);
            }
            });
        },
    

        addAnnouncement() {
            // Set the barangay ID for the new announcement using the store getter.
            this.newAnnouncement.barangay_id = this.$store.getters['auth/getBarangayId'];
            
            // Create a FormData object and append announcement info as JSON.
            const formData = new FormData();
            formData.append("announcementInfo", JSON.stringify(this.newAnnouncement));
            
            // Append the file if one was selected.
            if (this.file) {
                formData.append("file", this.file);
            }
            
            // Send AJAX request to the backend API.
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=add-announcement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                processData: false,
                contentType: false,
                data: formData,
                success: (data) => {
                    this.newAnnouncement = {};
                    this.file = null;
                    this.fetchBarangayAnnouncements();
                    console.log("Announcement data has been added successfully", data);
                
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error adding announcement:", textStatus, errorThrown);
                }
            });
        },



        fetchBarangayAnnouncements() {
            $.ajax({
            url: `${this.$store.getters.api_base}?e=barangay&a=announcements`,
            type: 'POST',
            xhrFields: {
                withCredentials: true
            },
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            },
            data: {
                barangayId: this.$store.getters['auth/getBarangayId'],
            },
            success: (data) => {
                this.announcements = data.data.announcements;
                console.log(data);
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
                // Optional: any actions after completion.
            }
            });
        }
    },
    created() {
        this.fetchBarangayAnnouncements();
    }
};
</script>

<style scoped>
.announcement-main {
    padding: 4rem 5rem;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    gap: 3rem;
}

h1 {
    text-align: center;
    font-size: 2rem;
    font-weight: bolder;
}

.announcement-img {
    border-radius: .5rem;
}

.announcement-card .delete-btn {
    display: none;
    transition: opacity 300ms ease-in-out;
}

.announcement-card:hover .delete-btn {
    display: block;
}
</style>