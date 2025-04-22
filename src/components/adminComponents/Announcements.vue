<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import FormAnnouncement from './subcomponents/FormAnnouncement.vue';
import $ from 'jquery';

export default {
    data() {
        return {
            announcements: {},
            editingIndex: null,
            showNewAnnouncement: false
        };
    },
    methods: {
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
        },
        closeForm() {
            this.showAddAnnouncementForm = false;
            this.file = null;
            this.filePreview = null;
            this.editing = false;
        },
        // Helper Methods
        formatDate(date) {
            if (!date) return "";
            const d = new Date(date);
            return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
        },
        editAnnouncement(announcement) {
            this.announcement = announcement;
            this.announcement.date = new Date(announcement.date);
            this.showAddAnnouncementForm = true;
            this.editing = true;
        },
        formatDateStr(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
            });
        }

    },
    watch: {
    },
    created() {
        this.fetchBarangayAnnouncements();
    },
    components: {
        VDateInput,
        FormAnnouncement
    }
};
</script>

<template>
    <v-container class="announcement-main">
        <!-- Title Section -->
        <div class="title d-flex items-center justify-center ma-5">
            <v-icon class="mr-5" size="75">mdi-bullhorn</v-icon>
            <h2 class="font-black text-3xl">ANNOUNCEMENTS</h2>
            <v-icon class="ml-5" size="75">mdi-bullhorn</v-icon>
        </div>

        <div class="w-full d-flex flex-row flex-wrap justify-evenly ga-10 items-start">
            <v-card 
            v-for="(announcement, index) in announcements" 
            :key="index"
            style="border-radius: 1rem;"
            class="announcement-card max-w-[450px] h-auto d-flex flex-col items-center justify-start ga-5 elevation-10 py-5 px-5"
            >
            <img 
                :src="announcement.img 
                        ? ($store.getters.base + '/announcements/' + announcement.img)
                        : ($store.getters.base + '/announcements/exx.jpg')"
                class="rounded w-[350px] h-[500px]"
                style="border-radius: .5rem;"
                cover
            ></img>

            <v-card-item class="w-[90%] relative py-5 pb-10 elevation-10">
                <h4 class="uppercase text-base font-extrabold">
                    {{ announcement.title }}
                </h4>

                <p class="text-sm font-medium">
                    {{ announcement.description }}
                </p>

                <span class="text-xs font-italic absolute bottom-0 right-0 pa-5">
                    {{ formatDateStr(announcement.date) }}
                </span>
            </v-card-item>

            <v-card-actions class="actions w-[70%] d-flex justify-evenly items-center py-5 hidden">
                <!-- The button is hidden by default; CSS will reveal it on hover -->
                <v-btn class="edit-btn" color="teal-lighten-1" @click="editingIndex = index" >EDIT</v-btn>
                <v-btn class="delete-btn" color="red-lighten-1" @click="confirmDelete(announcement.id)">DELETE</v-btn>
            </v-card-actions>

            <!-- Edit Achievement Form (shown for updating an achievement) -->
            <FormAnnouncement
                v-if="editingIndex === index"
                :action="'updating'"
                :announcement="announcement"
                @fetchInfo="fetchBarangayAnnouncements"
            />

            </v-card>
        </div>

        <v-btn
            class="d-flex items-center justify-center w-auto px-15 py-10 text-lg ma-5"
            elevation="10"
            @click="showNewAnnouncement = true"
            >
                <v-icon>mdi-plus-circle-outline</v-icon>
                <span class="ml-2">ADD ANNOUNCEMENT</span>
        </v-btn>


        <!-- New Announcement Dialog -->
        <FormAnnouncement
        v-if="showNewAnnouncement"
        :announcement="{}"
        :action="'adding'"
        @close="showNewAnnouncement = false"
        @fetchInfo="fetchBarangayAnnouncements">
        </FormAnnouncement>
    </v-container>
</template>

<style scoped>
.announcement-main {
    padding: 2rem 0rem;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    gap: 1rem;
    width: 90%;
}

.announcement-img {
    border-radius: .5rem;
}
</style>