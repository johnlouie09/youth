<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';

export default {
    props: {
        achievement: Object,
        action: String
    },
    emits: ["close", "fetchInfo"],
    data() {
        return {
        initialAchievementInfo: {},
        achievementInfo: {},
        officialNames: [],

        tempIdCounter: 0,

        // Data for Image Function
        files: [],
        filePreviews: [],

        // Helper Data
        dialog: true,
        hasChanges: false,
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
                this.achievementInfo = {
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
            const selectedFiles = Array.from(event.target.files);
            this.achievementInfo.images = this.achievementInfo.images || [];

            selectedFiles.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.files.push(file);

                    this.achievementInfo.images.push({
                        tempId: `temp_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`, // ✅ unique temp id
                        img: file.name,
                        preview: e.target.result,
                        isNew: true
                    });
                };
                reader.readAsDataURL(file);
            });
        },

        removeImage(index) {
            if (this.achievementInfo.images && this.achievementInfo.images[index]) {
                const removedImage = this.achievementInfo.images[index];

                // Remove from achievementInfo.images
                this.achievementInfo.images.splice(index, 1);

                // If it's a newly added file, also remove it from files[] by tempId
                if (removedImage.tempId) {
                    this.files = this.files.filter(f => f.name !== removedImage.name);
                }

                // ✅ If the removed image was the thumbnail, reset thumbnail to null
                if (
                    (this.achievementInfo.thumbnail_id && removedImage.id === this.achievementInfo.thumbnail_id) ||
                    (this.achievementInfo.thumbnail_tempId && removedImage.tempId === this.achievementInfo.thumbnail_tempId)
                ) {
                    this.achievementInfo.thumbnail = null;
                    this.achievementInfo.thumbnail_id = null;
                    this.achievementInfo.thumbnail_tempId = null;
                }
            }
        },

        setThumbnail(image) {
            this.achievementInfo.thumbnail = image;

            if (image.id) {
                this.achievementInfo.thumbnail_id = image.id; // DB image
                this.achievementInfo.thumbnail_tempId = null;
            } else {
                this.achievementInfo.thumbnail_id = null;
                this.achievementInfo.thumbnail_tempId = image.tempId; // New image
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
                images: (this.achievementInfo.images || []).map(img => ({
                    id: img.id || null,
                    tempId: img.tempId || null,
                    img: img.img,
                    achievement_id: this.achievementInfo.id || null
                }))
            };

            // remove the thumbnail object (not needed for backend)
            delete achievementData.thumbnail;

            const formData = new FormData();

            formData.append("achievementInfo", JSON.stringify(achievementData));

            if(this.files.length > 0) {
                this.files.forEach((file, i) => {
                    formData.append("files[]", file);  // ✅ backend should expect an array
                })
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
                images: (this.achievementInfo.images || []).map(img => ({
                    id: img.id || null,
                    tempId: img.tempId || null,
                    img: img.img,
                    achievement_id: this.achievementInfo.id || null
                }))
            };

            // remove the thumbnail object (not needed for backend)
            delete achievementData.thumbnail;

            const formData = new FormData();

            formData.append("achievementInfo", JSON.stringify(achievementData));

            if(this.files.length > 0) {
                this.files.forEach((file, i) => {
                    formData.append("files[]", file);  // ✅ backend should expect an array
                })
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

                    // ✅ find the thumbnail image
                    if (this.achievementInfo.thumbnail_id && this.achievementInfo.images) {
                    const thumb = this.achievementInfo.images.find(
                        img => img.id === this.achievementInfo.thumbnail_id
                    );
                    this.achievementInfo.thumbnail = thumb || null;
                    }
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
        <v-card elevation="5" class="d-flex flex-col justify-start items-center pa-10 gap-2 pb-5">
        
            <!-- Title Section: Display different titles based on the action prop -->
            <h3 class="w-full text-center pt-5 text-2xl font-extrabold">
            {{ editing ? 'UPDATING ACHIEVEMENT' : 'ADD ACHIEVEMENT' }}
            <v-divider class="my-2"></v-divider>
            </h3>

            <!-- Image Container and Achievement Form -->
            <div class="w-full pa-5 grid grid-cols-2 overflow-y-scroll ga-10">
                <!-- Achievement Display Image -->
                <!-- Image Form -->
                <div class="w-full d-flex items-start relative pa-0 col-span-1">
                    <div class="w-full grid grid-cols-2 ga-4">
                    
                        <div class="d-flex justify-evenly items-center col-span-2">
                            <v-img
                            :src="achievementInfo.thumbnail
                                    ? (achievementInfo.thumbnail.preview 
                                        ? achievementInfo.thumbnail.preview 
                                        : ($store.getters.base + 'public/Achievements/' + achievementInfo.thumbnail.img))
                                    : ($store.getters.base + 'public/Achievements/no-avatar.png')"
                            class="rounded-sm object-cover"
                            max-height="200"
                            
                            />
                        </div>



                        <div v-for="(image, index) in achievementInfo.images" 
                            :key="index"
                            class="col-span-1 relative">

                            <img
                                :src="image.preview ? image.preview : ($store.getters.base + 'public/Achievements/' + image.img)"
                                alt="Preview"
                                cover
                                class="rounded-sm w-full h-full"
                            />
                                                        
                            <!-- delete button -->
                            <v-btn 
                                icon size="25"
                                class="ma-2"
                                style="position: absolute; bottom: 0; right: 0;"
                                color="red-darken-3"
                                @click="removeImage(index)"
                            >
                                <v-icon size="15">mdi-delete</v-icon>
                            </v-btn>

                            <!-- ✅ set thumbnail button -->
                            <v-btn 
                                icon size="25"
                                :color="(
                                    (achievementInfo.thumbnail_id && achievementInfo.thumbnail_id === image.id) ||
                                    (achievementInfo.thumbnail_tempId && achievementInfo.thumbnail_tempId === image.tempId)
                                ) ? 'green-lighten-1' : 'primary'"
                                class="ma-2"
                                style="position: absolute; top: 0; right: 0;"
                                @click="setThumbnail(image)"
                            >
                                <v-icon size="15">
                                    {{
                                        (achievementInfo.thumbnail_id && achievementInfo.thumbnail_id === image.id) ||
                                        (achievementInfo.thumbnail_tempId && achievementInfo.thumbnail_tempId === image.tempId)
                                        ? 'mdi-star'
                                        : 'mdi-star-outline'
                                    }}
                                </v-icon>
                            </v-btn>
                        </div>


                        <div
                            class="custom-card d-flex justify-center items-center col-span-1 border-2 border-dashed"
                            @click="triggerFileInput"
                        >
                        <v-icon size="40">
                            mdi-plus
                        </v-icon>
                        </div>
                    </div>
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
            <v-card-actions 
            v-if="hasChanges" 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;">
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

    <!-- File Upload Input -->
    <input
    ref="fileInput"
    type="file"
    accept="image/*"
    class="hidden"
    multiple
    @change="handleFileUpload"
    />
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
  