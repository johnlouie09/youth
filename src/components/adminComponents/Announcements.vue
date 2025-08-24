<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import FormAnnouncement from './subcomponents/FormAnnouncement.vue';
import $ from 'jquery';

export default {
    data() {
        return {
            announcements: {},
            editingIndex: null,
            showNewAnnouncement: false,
            items: [],
            selectedAnnouncementSort: 'featured',  // all | featured | month
            selectedMonth: null               // holds actual month string
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
        fetchBarangayFeaturedAnnouncements() {
            $.ajax({
            url: `${this.$store.getters.api_base}?e=barangay&a=featured-announcements`,
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
        fetchBarangayAnnouncementsByMonth(month) {
            $.ajax({
                url: `${this.$store.getters.api_base}?e=barangay&a=announcements-by-month`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                data: {
                    barangayId: this.$store.getters['auth/getBarangayId'],
                    month: month
                },
                success: (data) => {
                    this.announcements = data.data.announcements;
                    console.log("Announcements for month:", month, data);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error fetching announcements by month:", textStatus, errorThrown);
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
        },
        refreshAnnouncements() {
        if (this.selectedAnnouncementSort === 'all') {
            this.fetchBarangayAnnouncements();
        } else if (this.selectedAnnouncementSort === 'featured') {
            this.fetchBarangayFeaturedAnnouncements();
        } else if (this.selectedAnnouncementSort === 'month' && this.selectedMonth && this.selectedMonth !== 'Select a Month') {
            this.fetchBarangayAnnouncementsByMonth(this.selectedMonth);
        }
        }, 
        // Fetch available year-months
        fetchAvailableMonths() {
            $.ajax({
                url: `${this.$store.getters.api_base}?e=barangay&a=available-year-months`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                data: {
                    barangayId: this.$store.getters['auth/getBarangayId']
                },
                success: (data) => {
                    // Backend returns e.g. ["2025-08", "2025-07", "2024-12"]
                    const months = data.data.yearMonths.map(ym => {
                        const [year, month] = ym.split('-');
                        const monthName = new Date(ym + '-01').toLocaleString('en-US', { month: 'long' });
                        return `${monthName} ${year}`;
                    });

                    // Add default option
                    this.items = ['Select a Month', ...months];
                    this.selectedMonth = this.items[0];
                    console.log("Available months:", this.items);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error fetching months:", textStatus, errorThrown);
                }
            });
        }
    },
    watch: {
    selectedAnnouncementSort(newVal) {
        if (newVal === 'all') {
        this.fetchBarangayAnnouncements();
        } else if (newVal === 'featured') {
        this.fetchBarangayFeaturedAnnouncements();
        } else if (newVal === 'month' && this.selectedMonth && this.selectedMonth !== 'Select a Month') {
        this.fetchBarangayAnnouncementsByMonth(this.selectedMonth);
        }
    },
    selectedMonth(newMonth) {
        // Only fetch if the "month" tab is active
        if (this.selectedAnnouncementSort === 'month' && newMonth && newMonth !== 'Select a Month') {
        this.fetchBarangayAnnouncementsByMonth(newMonth);
        }
    }
    },
    created() {
        this.fetchBarangayFeaturedAnnouncements();
        this.fetchAvailableMonths(); 
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
            <v-icon class="mr-5 scale-x-[-1]" size="75">mdi-bullhorn</v-icon>
            <h2 class="font-black text-3xl">ANNOUNCEMENTS</h2>
            <v-icon class="ml-5" size="75">mdi-bullhorn</v-icon>
        </div>

        <v-tabs v-model="selectedAnnouncementSort" grow class="my-5">
        <div class="grid grid-cols-3 ga-5 w-full">
            <v-tab value='all' class="border rounded-md col-span-1">ALL</v-tab>
            <v-tab value='featured' class="border rounded-md col-span-1">FEATURED</v-tab>
            <v-tab value="month" class="border rounded-md col-span-1">
                <v-select
                    v-model="selectedMonth"
                    class="border rounded-md w-full"
                    :items="items"
                    density="comfortable"
                    hide-details
                />
            </v-tab>


        </div>
        </v-tabs>


        <div class="w-full d-flex flex-row flex-wrap justify-evenly ga-10 items-start">
            <v-card 
            v-for="(announcement, index) in announcements" 
            :key="index"
            style="border-radius: 1rem;"
            class="announcement-card max-w-[450px] h-auto d-flex flex-col items-center justify-start ga-5 elevation-10 py-5 px-5"
            >

            <!-- Featured Icon -->
            <v-icon 
                v-if="announcement.is_featured" 
                color="yellow darken-2" 
                size="50" 
                style="position: absolute; top: 0; right: 0; z-index: 10;"
                title="Featured Announcement"
            >
                mdi-star
            </v-icon>

            <img 
                :src="announcement.img 
                        ? ($store.getters.base + 'public/announcements/' + announcement.img)
                        : ($store.getters.base + 'public/announcements/no-avatar.png')"
                class="rounded w-[350px] h-[500px]"
                style="border-radius: .5rem;"
                cover
            ></img>

            <v-card-item class="w-[90%] py-5 pb-10 elevation-10">
                <h4 class="uppercase text-base font-extrabold text-center mb-2">
                    {{ announcement.title }}
                </h4>

                <p class="text-sm font-medium text-center">
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
                @close="editingIndex = null"
                :announcement="announcement"
                @fetchInfo="refreshAnnouncements"
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
        @fetchInfo="refreshAnnouncements"
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