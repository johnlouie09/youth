<script>
import FormAchievement from './subcomponents/officials/InputForms/FormAchievement.vue';
import $ from 'jquery';

export default {
    components: {
        FormAchievement,
    },

    data() {
        return {
            hoverIndex: null,
            editingIndex: null,
            achievements: [],
            allAchievements: [],
            personalAchievements: [],
            showNewAchievement: false,
            
            items: [],
            selectedAchievementSort: 'all',  
            selectedMonth: 'Select a Month' // ✅ default value
        };
    },

    methods: {
        /**
        * Set the editing index for a given achievement.
        */
        editAchievement(index) {
            this.editingIndex = index;
        },

        /**
        * Format a date string to a localized string.
        */
        formatDate(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        },

        fetchBarangayAchievements() {
            $.ajax({
                url: `${this.$store.getters.api_base}?e=barangay&a=achievements`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                data: {
                    barangayId: this.$store.getters['auth/getBarangayId'],
                },
                success: (data) => {
                    this.allAchievements = data.data.achievements; // ✅ keep original
                    this.achievements = [...this.allAchievements]; // show all initially
                    this.populateMonths();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        },

        filterAchievementsByMonth(monthYear) {
            if (!monthYear || monthYear === 'Select a Month') {
                // Reset back to all
                this.achievements = [...this.allAchievements];
                return;
            }

            this.achievements = this.allAchievements.filter(achievement => {
                if (!achievement.dates) return false;

                return achievement.dates.some(d => {
                    if (!d.date) return false;

                    // Parse "2025-07-25" or "2025,07,25"
                    const parts = d.date.includes('-') ? d.date.split('-') : d.date.split(',');
                    const date = new Date(parts[0], parts[1] - 1, parts[2]);

                    const formatted = date.toLocaleDateString('en-US', {
                        month: 'long',
                        year: 'numeric'
                    });

                    return formatted === monthYear;
                });
            });
        },



        populateMonths() {
            const monthYearSet = new Set();

            this.achievements.forEach(achievement => {
                if (achievement.dates && Array.isArray(achievement.dates)) {
                    achievement.dates.forEach(d => {
                        if (d.date) {
                            // Convert '2025,07,25' → Date object
                            const parts = d.date.split('-');
                            const date = new Date(parts[0], parts[1] - 1, parts[2]);

                            // Format "April 2002"
                            const monthYear = date.toLocaleDateString('en-US', {
                                month: 'long',
                                year: 'numeric'
                            });

                            monthYearSet.add(monthYear);
                        }
                    });
                }
            });

            // Convert Set → Array of strings like "April 2002"
            this.items = Array.from(monthYearSet).sort((a, b) => {
                // Parse back into Date for sorting
                const [monthA, yearA] = a.split(' ');
                const [monthB, yearB] = b.split(' ');
                const dateA = new Date(`${monthA} 1, ${yearA}`);
                const dateB = new Date(`${monthB} 1, ${yearB}`);
                return dateB - dateA; // latest first
            });

            // Add "Select a Month" at the beginning
            this.items.unshift('Select a Month');

            console.log("📅 Available Months:", this.items);
        },


        /**
        * Shows a confirmation dialog for deletion and, if confirmed,
        * calls the deleteAchievement method.
        */
        async confirmDelete(achievementId) {
            this.$store.commit('dialog/confirm/show', {
                title: 'Delete Achievement',
                prompt: 'Are you sure you want to delete this achievement?',
                color: 'red',
                yesText: 'Delete',
                noText: 'Cancel',
                onConfirm: async () => {
                    await this.deleteAchievement(achievementId);
                },
                onCancel: () => {
                    console.log('Deletion cancelled');
                }
            });
        },

        /**
        * Deletes an achievement via an AJAX request.
        */
        deleteAchievement(achievementId) {
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=sk-official&a=deleteAchievement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                data: { id: achievementId },
                success: (data) => {
                    console.log("Achievement deleted successfully", data);
                    // Emit event to refresh official information
                    this.fetchBarangayAchievements();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error deleting achievement:", textStatus, errorThrown);
                }
            });
        }
    },
    created() {
        this.fetchBarangayAchievements(); 
    },
    computed : {

    },
    watch: {
        selectedAchievementSort(newVal) {
            if (newVal === 'all') {
                this.achievements = [...this.allAchievements];
            } else if (newVal === 'month' && this.selectedMonth && this.selectedMonth !== 'Select a Month') {
                this.filterAchievementsByMonth(this.selectedMonth);
            }
        },
        selectedMonth(newVal) {
            if (this.selectedAchievementSort === 'month') {
                this.filterAchievementsByMonth(newVal);
            }
        }
    }
};
</script>

<template>
    <v-container class="achievements-section">
        <!-- Title Section -->
        <v-card-title class="title d-flex items-center justify-center ma-5">
            <v-icon class="mr-3" size="75">mdi-trophy</v-icon>
            <h2 class="font-black text-3xl">BARANGAY ACHIEVEMENTS</h2>
            <v-icon class="ml-3" size="75">mdi-trophy</v-icon>
        </v-card-title>

        <!-- Achievement Sorting Selector -->
        <v-tabs v-model="selectedAchievementSort" grow class="my-5">
            <div class="grid grid-cols-2 ga-5 w-full">
                <v-tab value='all' class="border rounded-md col-span-1">ALL</v-tab>
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
        

        <!-- Achievements List -->
        <div class="achievements-cards">
            <v-container class="d-flex flex-row flex-wrap justify-evenly p-5 pt-0 gap-10">
                <v-card
                    v-for="(achievement, index) in achievements"
                    :key="index"
                    class="achievement-card w-[30%] min-w-[250px] rounded-lg d-flex flex-col justify-start items-center pb-10"
                    elevation="5"
                    @mouseover="hoverIndex = index"
                    @mouseleave="hoverIndex = null"
                >
                    <!-- Achievement Image -->
                    <img
                        :src="achievement.img 
                        ? ($store.getters.base + 'public/achievements/' + achievement.img)
                        : ($store.getters.base + 'public/achievements/no-avatar.png')"


                        alt=""
                        class="elevation-5 w-full max-h-[225px] rounded-t-lg"
                    />

                    <!-- Achievement Details -->
                    <article class="d-flex flex-col items-start w-[90%] my-5">
                        <h3 class="uppercase text-lg font-extrabold">{{ achievement.title }}</h3>
                        <h5 class="text-base font-medium">{{ achievement.subtitle }}</h5>
                        <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) }}</h5>
                    </article>

                    <v-card class="w-[80%] d-flex items-center ga-1 px-5 mb-5 elevation-5">
                        <v-avatar :image="(achievement.sk_official_img ? ($store.getters.base + 'public/OfficialImages/' + achievement.sk_official_img) : ($store.getters.base + 'public/OfficialImages/no-avatar.png'))" size="50"></v-avatar>
                        <v-card-text class="d-flex flex-col">
                            <span class="text-sm">Hon. {{ achievement.sk_official_name }}</span>
                            <span class="uppercase text-xs">{{ achievement.sk_official_position }}</span>
                        </v-card-text>
                    </v-card>

                    <!-- Action Buttons on Hover -->
                    <transition name="fade">
                        <div v-if="hoverIndex === index" class="achievement-card-actions">
                            <v-icon class="edit-icon" size="25" @click="editAchievement(index)">mdi-pencil-circle</v-icon>
                            <v-icon class="delete-icon" size="25" @click="confirmDelete(achievement.id)">mdi-delete-circle</v-icon>
                        </div>
                    </transition>

                    <!-- Edit Achievement Form (shown for updating an achievement) -->
                    <FormAchievement
                        v-if="editingIndex === index"
                        :action="'updating'"
                        :achievement="achievement"
                        @close="editingIndex = null"
                        @fetchInfo="fetchBarangayAchievements"
                    />
                </v-card>
            </v-container>

            <!-- Add New Achievement Button -->
            <v-btn
                class="d-flex items-center justify-center w-auto px-15 py-10 text-lg ma-5"
                elevation="10"
                @click="showNewAchievement = true"
            >
                <v-icon>mdi-plus-circle-outline</v-icon>
                <span class="ml-2">ADD PERSONAL ACHIEVEMENT</span>
            </v-btn>
        </div>

        <!-- New Achievement Dialog -->
        <FormAchievement
            v-if="showNewAchievement"
            :achievement="{ sk_official_id: id }"
            :action="'adding'"
            @close="showNewAchievement = false"
            @fetchInfo="fetchBarangayAchievements"
        />
    </v-container>
</template>

<style scoped>
.achievement-card {
    transition: transform 0.3s ease;
}

.achievement-card:hover {
    transform: scale(1.05);
}

/* Other existing styles */
.achievements-section {
    padding: 2rem 0rem;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    gap: 1rem;
    width: 100%;
}

.achievements-cards {
    padding: 1rem 2rem;
    width: 90%;
    display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    flex-wrap: wrap;
}

.achievement-card-actions {
    position: absolute;
    bottom: 0;
    left: 0;
    padding: 1rem;
    display: flex;
    gap: 10px;
}

.edit-icon, .delete-icon {
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.edit-icon:hover {
    transform: scale(1.1);
    color: #4caf4fa1;
}

.delete-icon:hover {
    transform: scale(1.1);
    color: #f443369c;
}
</style>

  