<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';

export default {
    props: {
        achievement: Object,
        action: String
    },
    data() {
        return {
        initialAchievementInfo: {},
        achievementInfo: {},
        officialNames: [],
        dialog: true,
        tempIdCounter: 0,

        // Flag to track if changes have been made
        hasChanges: false,
        // For file upload handling
        file: null,
        filePreview: null,
        };
    },
    methods: {
        formatDate(date) {
            if (!date) return "";
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0'); // always 2 digits
            const day = String(d.getDate()).padStart(2, '0');        // always 2 digits
            return `${year}-${month}-${day}`;
        },
                initializeAchievementInfo() {
            if (!this.editing) {
                this.announcementInfo = {
                    sk_official_id          : '',
                    title                   : '',
                    subtitle                : '',
                    info                    : '',
                    sk_official_comment     : '',
                    sk_official_img         : '',
                    sk_official_position    : '',
                    dates                   : []
                };
            }
        },

        removeDate(index) {
            this.achievementInfo.dates.splice(index, 1);
        },

        // Methods for Button
        saveChanges() {
            // Format date fields as strings before sending
            this.achievementInfo.date = this.formatDate(this.achievementInfo.date);
            
            // Depending on the action prop, either update or add an achievement.
            if (this.action === 'updating' || this.action === 'updating-main') {
                this.updateAchievement();
            } else if (this.action === 'adding' || this.action === 'adding-main') {
                this.addAchievement();
            }
            
            // Reset change flag and close the dialog
            this.hasChanges = false;
            this.dialog = false;
        },
        discardChanges() {
            this.achievementInfo = { ...this.initialAchievementInfo };
            this.file = null;
            this.filePreview = null;
            this.hasChanges = false;
        },
        closeForm() {
            this.$emit('close');
        },
        updateDate(newDate) {
            this.achievementInfo.date = newDate;
        },

        // Method for Handling File Upload
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.file = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                this.filePreview = e.target.result;
                // Store the filename for later use.
                this.achievementInfo.img = file.name;
                };
                reader.readAsDataURL(file);
            }
        },

        //AJAX Methods for Updating and Adding Achievements
        updateAchievement() {
            // Clean up datetime objects - remove tempId for database operations
            const cleanDates = this.achievementInfo.dates.map(dt => ({
                id: dt.id, // Keep existing IDs, will be null for new entries
                date: dt.date,
            }));

            const achievementData = {
                ...this.achievementInfo,
                thumbnail_id: this.achievementInfo.thumbnail_id || null,
                thumbnail_tempId: this.achievementInfo.thumbnail_tempId || null,
                dates: cleanDates,
            };

            // remove the thumbnail object (not needed for backend)
            delete achievementData.thumbnail;

            const formData = new FormData();

            formData.append("achievementInfo", JSON.stringify(achievementData));
            if (this.file) {
                formData.append("file", this.file);
            }
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=sk-official&a=updateAchievement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                processData: false,
                contentType: false,
                data: formData,
                success: (data) => {
                console.log("Data has been updated successfully", data);
                // Convert date string back to a Date object for v-date-input
                this.achievementInfo.date = new Date(this.achievementInfo.date);
                // Update the original info to match current info
                this.initialAchievementInfo = { ...this.achievementInfo };
                this.hasChanges = false;
                this.file = null;
                this.filePreview = null;
                // Emit an event to notify the parent that an update occurred
                this.$emit("fetchInfo", true);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                }
            });
        },
        addAchievement() {
            const formData = new FormData();
            formData.append("achievementInfo", JSON.stringify(this.achievementInfo));
            if (this.file) {
                formData.append("file", this.file);
            }
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=sk-official&a=addAchievement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                processData: false,
                contentType: false,
                data: formData,
                success: (data) => {
                console.log("Data has been added successfully", data);
                // Convert date string back to a Date object for v-date-input
                this.achievementInfo.date = new Date(this.achievementInfo.date);
                // Update the original info so all references are in sync
                this.initialAchievementInfo = { ...this.achievementInfo };
                this.hasChanges = false;
                this.filePreview = null;
                // Emit an event to notify the parent that a new achievement was added
                this.$emit("fetchInfo", true);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                }
            });
        },

        getOfficials() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=sk-officials`,
                type: 'POST',
                xhrFields: {
                withCredentials: true
                },
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    barangayId: this.$store.getters['auth/getBarangayId'],
                },
                success: (data) => {
                    this.officialNames = [data.data.skChairman, ...data.data.skMembers];
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
        },

        findOfficialIdByName(name) {
            // Search the officialNames array for an official with the matching full_name.
            const official = this.officialNames.find(item => item.full_name === name);
            return official ? official.id : null;
        }
    },

    computed: {
        editing() {
            if(this.action === "updating") {
                return true;
            }
            else {
                return false;
            }
        },
        officialNamesList() {
            return this.officialNames.map(official => official.full_name);
        },


        selectedDates: {
            get() {
                // Always convert to Date object for v-date-input to work
                if(this.achievementInfo.dates && this.achievementInfo.dates.length > 0) {
                    return this.achievementInfo.dates.map(d => new Date(d.date));
                }
                return [];
            },
            set(newDates) {
                if (!newDates || newDates.length === 0) {
                    this.achievementInfo.dates = [];
                    return;
                }

                // Get existing datetimes by date to preserve times when dates are reselected
                const existingByDate = {};
                if (this.achievementInfo.dates) {
                    this.achievementInfo.dates.forEach(dt => {
                        existingByDate[dt.date] = dt;
                    });
                }

                // Create new datetimes array based on selected dates
                this.achievementInfo.dates = newDates.map((date) => {
                const dateString = this.formatDate(date);

                // If this date already exists, keep the existing data
                if (existingByDate[dateString]) {
                    return existingByDate[dateString];
                }

                // Otherwise, create a new datetime entry
                return {
                    id: null, // will be set after saving to DB
                    tempId: `temp_${++this.tempIdCounter}`, // ✅ only used for new ones
                    date: dateString,
                };
                });

            }
        }
    },

    watch: {
        // Watch the entire "achievement" prop and update local copies accordingly.
        achievement: {
            immediate: true,
            handler(newVal) {
            if (newVal && Object.keys(newVal).length > 0) {
                this.achievementInfo = JSON.parse(JSON.stringify(newVal));
            }

            // Keep an initial copy for change detection.
            this.initialAchievementInfo = JSON.parse(JSON.stringify(this.achievementInfo));

            // Fetch the list of officials to map names to IDs.
            this.getOfficials();
            },
            deep: true
        },

        // Watch other fields in achievementInfo
        achievementInfo: {
            handler(newVal) {
                this.hasChanges =
                    JSON.stringify(newVal) !== JSON.stringify(this.initialAchievementInfo);
            },
            deep: true
        },

        // Watch the nested property "achievement.sk_official_name" and update the ID.
        'achievementInfo.sk_official_name': {
            immediate: true,
            handler(newVal) {
            if (newVal && newVal.trim() !== '') {
                const newId = this.findOfficialIdByName(newVal);
                if (newId !== null) {
                this.achievementInfo.sk_official_id = newId;
                }
            } else {
                this.achievementInfo.sk_official_id = this.initialAchievementInfo.sk_official_id;
            }
            }
        }
    },

    components: {
        VDateInput
    },
    created() {
        // Initialize for new achievement
        if (!this.editing && (!this.achievement || Object.keys(this.achievement).length === 0)) {
            this.initializeAchievementInfo();
            this.initialAchievementInfo = JSON.parse(JSON.stringify(this.achievementInfo));
        }
    }
};
</script>

<template>
    <v-dialog width="1100px" max-height="90vh" v-model="dialog" persistent>
        <v-card elevation="5" class="d-flex flex-col items-center pa-10 gap-6">
        
        <!-- Title Section: Display different titles based on the action prop -->
        <div class="w-full d-flex items-center justify-center gap-2">
            <h3 class="w-full text-center py-5 text-2xl font-extrabold">
            {{ editing ? 'UPDATING ACHIEVEMENT' : 'ADD ACHIEVEMENT' }}
            <v-divider class="my-2"></v-divider>
            </h3>
        </div>

        <!-- Image Container and Achievement Form -->
        <div class="w-full grid grid-cols-2 ga-10">
            <!-- Achievement Display Image -->
            <div class="col-span-1 d-flex justify-center items-center relative">
                <v-img
                :src="filePreview || (achievementInfo.img ? ($store.getters.base + 'achievements/' + achievementInfo.img) : ($store.getters.base + 'exx.jpg'))"
                alt=""
                class="elevation-5 rounded-lg"
                ></v-img>

                <!-- Camera Icon Button to trigger file input -->
                <v-btn class="upload-icon ma-3" icon @click="triggerFileInput">
                    <v-icon>mdi-camera</v-icon>
                </v-btn>
                
                <!-- Hidden File Input -->
                <input 
                ref="fileInput" 
                type="file" 
                accept="image/*" 
                class="hidden"
                @change="handleFileUpload"
                >
            </div>
            
            <!-- Achievement Form -->
            <article class="col-span-1 d-flex flex-col items-start">
                <!-- Achievement Title -->
                <v-text-field
                class="w-full text-lg uppercase"
                v-model="achievementInfo.title"
                label="Achievement Title"
                variant="outlined"
                required
                ></v-text-field>
                
                <!-- Achievement Subtitle -->
                <v-text-field
                class="w-full text-lg uppercase"
                v-model="achievementInfo.subtitle"
                label="Achievement Subtitle"
                variant="outlined"
                required
                ></v-text-field>

                <!-- Achievement Info -->
                <v-textarea
                class="w-full text-lg uppercase"
                v-model="achievementInfo.info"
                label="Achievement Info"
                variant="outlined"
                required
                auto-grow
                rows="1"
                ></v-textarea>

                <!-- Achievement SK Official Selector -->
                <v-select
                    v-if="action ==='adding-main' || action === 'updating-main'"
                    class="w-full"
                    v-model="achievementInfo.sk_official_name"
                    :items="officialNamesList"
                    label="Select Official Name"
                    outlined
                />

                <!-- Achievement SK Official Comment -->
                <v-textarea
                class="w-full text-lg uppercase"
                v-model="achievementInfo.sk_official_comment"
                label="Sk official comment"
                variant="outlined"
                required
                auto-grow
                rows="1"
                ></v-textarea>

                <!-- Achievement Date Picker -->
                <div class="w-full">
                    <v-date-input
                    v-model="selectedDates"
                    label="When"
                    class="text-xs font-italic relative bottom-0 right-0 w-full"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="outlined"
                    multiple
                    />

                    <v-card class="w-full d-flex flex-wrap justify-evenly items-center ga-2 border rounded-sm pa-3" v-if="achievementInfo.dates && achievementInfo.dates.length > 0">
                        <div v-for="(date, index) in achievementInfo.dates" :key="date.tempId || date.id || index"
                            class="border d-flex flex-wrap justify-center items-center px-4 py-2 ga-2">

                            <h4>{{ new Date(date.date).toLocaleDateString('en-US', { 
                                month: 'long', 
                                day: 'numeric', 
                                year: 'numeric' }) }}</h4>


                            <!-- Delete datetime button (only show if more than 1 datetime) -->
                            <v-btn 
                                v-if="achievementInfo.dates.length > 0"
                                icon 
                                size="25" 
                                color="red-darken-3" 
                                @click="removeDate(index)"
                                class="ml-2"
                            >
                                <v-icon size="13">mdi-delete</v-icon>
                            </v-btn>

                        </div>
                    </v-card>
                    
                    <!-- Empty state when no datetimes -->
                    <v-card v-else class="w-full pa-4 text-center">
                        <p class="text-gray-500">Select dates above to add event times</p>
                    </v-card>
                </div>

            </article>
        </div>
        

        
        <!-- Action Buttons: Save/Discard -->
        <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center gap-10">
            <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
            <v-btn v-if="action === 'adding' || action === 'adding-main'" color="teal-lighten-1" @click="saveChanges">Add Achievement</v-btn>
            <v-btn v-if="action === 'updating' || action === 'updating-main'" color="teal-lighten-1" @click="saveChanges">Save Changes</v-btn>
        </v-card-actions>
        
        <!-- Close Dialog Button -->
        <v-card-actions class="absolute top-0 right-0 pa-5">
            <v-btn icon color="error" @click="closeForm">
            <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-card-actions>
        
        </v-card>
    </v-dialog>
</template>

<style scoped>
    /* Custom button style if needed */
    .add-ebg-button {
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem;
        margin: auto;
        font-size: 0.7rem;
    }

    /* Floating Upload Icon styling */
    .upload-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        width: 48px;
    }
</style>
  