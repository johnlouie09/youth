<template>
    <v-dialog width="900px" v-model="dialog" persistent>
        <v-card class="d-flex justify-center items-center pa-10" style="border-radius: 1rem;">
            <!-- Image Container and Achievement Form -->
            <div class="d-flex items-start gap-5 w-full">
                <div class="d-flex items-start relative pa-0">
                    <v-img
                    :src="filePreview || (announcementInfo.img ? ($store.getters.base + 'public/announcements/' + announcementInfo.img) : '/public/announcements/no-avatar.png')"
                    alt="Profile Image" 
                    cover
                    width="400"
                    class="rounded-lg"
                    />

                    <!-- Floating Upload Icon -->
                    <v-btn class="upload-icon" icon @click="triggerFileInput" size="40">
                        <v-icon size="15">mdi-camera</v-icon>
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
                <article class="d-flex flex-col justify-center items-center gap-5 w-full ma-auto ">    
                    <!-- Title Section: Display different titles based on the action prop -->
                    <div class="d-flex items-center justify-center gap-2">
                        <h3 v-if="editing" class="gradient-text py-5 text-2xl font-extrabold">
                                UPDATING ANNOUNCEMENT
                        </h3>

                        <h3 v-else class="gradient-text py-5 text-2xl font-extrabold">
                        NEW ANNOUNCEMENT
                        </h3>
                    </div>

                    <!-- Announcement Title -->
                    <v-text-field
                    class="w-full text-lg"
                    v-model="announcementInfo.title"
                    label="Announcement Title"
                    variant="outlined"
                    required
                    ></v-text-field>
                    
                    <!-- Announcement Subtitle -->
                    <v-text-field
                    class="w-full text-lg"
                    v-model="announcementInfo.description"
                    label="Announcement Description"
                    variant="outlined"
                    required
                    ></v-text-field>

                    <!-- Announcement Date Picker -->
                    <v-date-input
                    v-model="announcementInfo.date"
                    label="Select a date"
                    class="text-xs font-italic relative bottom-0 right-0 w-full"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="solo"
                    />

                    <v-checkbox
                        v-model="announcementInfo.is_featured"
                        color="success"
                        label="Feature Announcement"
                    ></v-checkbox>



                    <!-- Action Buttons: Save/Discard -->
                    <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center gap-10">
                        <v-btn color="red-lighten-1" @click="discardChanges">DISCARD CHANGES</v-btn>
                        <v-btn v-if="action === 'adding' || action === 'adding-main'" color="teal-lighten-1" @click="saveChanges">Add Achievement</v-btn>
                        <v-btn v-if="action === 'updating' || action === 'updating-main'" color="teal-lighten-1" @click="saveChanges">UPDATE</v-btn>
                    </v-card-actions>
                </article>
            </div>

            <!-- Close Dialog Button -->
            <v-card-actions class="absolute top-0 right-0 pa-5">
                <v-btn icon color="error" @click="closeForm">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <input
        ref="fileInput"
        type="file"
        accept="image/*"
        class="hidden"
        @change="handleFileUpload"
    />
</template>

<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';

export default {
    props: {
        announcement: Object,
        action: String
    },
    components: {
        VDateInput
    },
    data() {
        return {
            initialAnnouncementInfo : {},
            announcementInfo: {},
            dialog: true,
            hasChanges: false,
            file: null,
            filePreview : null,
        };
    },
    methods: {
        saveChanges() {
            // Format date fields as strings before sending
            this.announcementInfo.date = this.formatDate(this.announcementInfo.date);
            
            // Depending on the action prop, either update or add an achievement.
            if (this.action === 'updating') {
                this.updateAnnouncement();
            } else if (this.action === 'adding') {
                this.addAnnouupdateAnnouncement();
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
            this.initialAnnouncementInfo = {};
            this.announcementInfo = {};
            this.dialog = false;
            this.hasChanges = false;
            this.file = null;
            this.filePreview = null;
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const width = img.width;
                    const height = img.height;

                    const gcd = (a, b) => (b === 0 ? a : gcd(b, a % b));
                    const divisor = gcd(width, height);
                    const simplifiedWidth = Math.round(width / divisor);
                    const simplifiedHeight = Math.round(height / divisor);

                    const readableRatio = `${simplifiedWidth}:${simplifiedHeight}`;
                    const recommendedRatio = '7:10';

                    const aspectRatio = (width / height).toFixed(2);
                    const recommendedDecimal = (7 / 10).toFixed(2);

                    if (Math.abs(aspectRatio - recommendedDecimal) > 0.05) {
                    const examples = [
                        '280x400',
                        '420x600',
                        '560x800',
                        '700x1000',
                        '1050x1500',
                        '1400x2000',
                        '1680x2400',
                        '2100x3000'
                    ];

                    const exampleList = examples.map(r => `• ${r}`).join('\n');

                    this.$store.commit('dialog/confirm/show', {
                        title: 'Image Ratio Warning',
                        prompt: `The uploaded image has a ratio of ${readableRatio} (W:H).\nRecommended ratio is ${recommendedRatio}.\n\n📏 Example resolutions:\n${exampleList}\n\nDo you still want to proceed?`,
                        color: 'warning',
                        yesText: 'Proceed Anyway',
                        noText: 'Cancel',
                        onConfirm: () => {
                        this.file = file;
                        this.filePreview = e.target.result;
                        this.announcementInfo.img = file.name;
                        },
                        onCancel: () => {
                        this.file = null;
                        this.filePreview = null;
                        }
                    });
                    } 
                    else {
                    this.file = file;
                    this.filePreview = e.target.result;
                    this.announcementInfo.img = file.name;
                    }
                };
                img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        addAnnouncement() {
            // Format the announcement date as needed.
            this.announcementInfo.date = this.formatDate(this.announcementInfo.date);
            // Ensure is_featured is set (default to 0 if undefined)
            if (typeof this.announcementInfo.is_featured === 'undefined') {
                this.announcementInfo.is_featured = 0;
            }
            // Set the barangay ID from the store
            this.announcementInfo.barangay_id = this.$store.getters['auth/getBarangayId'];
            
            // Create a FormData object and append the announcement info as a JSON string.
            const formData = new FormData();
            formData.append("announcementInfo", JSON.stringify(this.announcement));
            
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
                // Clear the announcement data and file references
                this.announcement = {};
                this.file = null;
                this.fetchBarangayAnnouncements();
                console.log("Announcement data has been added successfully", data);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error adding announcement:", textStatus, errorThrown);
                },
                complete: () => {
                this.showAddAnnouncementForm = false;
                this.file = null;
                this.filePreview = null;
                }
            });
        },
        updateAnnouncement() {
            // Format date fields before sending to the API.
            this.announcementInfo.date = this.formatDate(this.announcementInfo.date);
            
            // Create a FormData object and append the announcement info as a JSON string.
            const formData = new FormData();
            formData.append("announcementInfo", JSON.stringify(this.announcement));
            
            // Append the file if one was selected.
            if (this.file) {
                formData.append("file", this.file);
            }
            
            // Send AJAX request to update the announcementInfo.
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=update-announcement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                processData: false,
                contentType: false,
                data: formData,
                success: (data) => {
                console.log("Announcement updated successfully", data);
                // Refresh announcements list
                this.fetchBarangayAnnouncements();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error updating announcement:", textStatus, errorThrown);
                },
                complete: () => {
                // Reset file and close the update dialog.
                this.announcement = {}
                this.editing = false;
                this.showAddAnnouncementForm = false;
                this.file = null;
                this.filePreview = null;
                }
            });
        },

        formatDate(date) {
        if (!date) return "";
            const d = new Date(date);
            return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
        },
    },
    watch: {
        announcement: {
            immediate: true,
            handler(newVal) {
            // Create local copies from the provided achievement prop.
            this.announcementInfo = { ...newVal };
            if (newVal.date) {
                this.announcementInfo.date = new Date(newVal.date);
            }
                // Keep an initial copy for change detection.
                this.initialAnnouncementInfo = { ...this.announcementInfo };
            },
            deep: true
        },
          // Watch for any changes in achievementInfo to update the hasChanges flag.
        announcementInfo: {
            handler(newVal) {
            this.hasChanges =
                JSON.stringify(newVal) !== JSON.stringify(this.initialAnnouncementInfo);
            },
            deep: true
        }
    },
    created() {
    },
};
</script>

<style scoped>

/* Floating Upload Icon styling */
.upload-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 48px;
    margin: 1rem;
}

</style>