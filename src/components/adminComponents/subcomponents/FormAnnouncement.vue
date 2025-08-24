<template>
    <v-dialog width="1400px" v-model="dialog" persistent>
        <v-card class="d-flex justify-start items-center pa-10" style="border-radius: 1rem;">
            <!-- Title Section: Display different titles based on the action prop -->
            <h3 v-if="editing" class="w-full text-center py-5 text-2xl font-extrabold">
                UPDATING ANNOUNCEMENT
                <v-divider class="my-2"></v-divider>

            </h3>

            <h3 v-else class="w-full text-center py-5 text-2xl font-extrabold">
                NEW ANNOUNCEMENT
                <v-divider class="my-2"></v-divider>
            </h3>

            <!-- Image Container and Achievement Form -->
            <div class="w-full grid grid-cols-3 ga-10">

                <!-- Image Form -->
                <div class="w-full d-flex items-start relative pa-0 col-span-1">
                    <div class="w-full grid grid-cols-3 ga-4">
                    
                        <div class="d-flex justify-evenly items-center col-span-3">
                            <img
                            :src="announcementInfo.thumbnail
                                    ? (announcementInfo.thumbnail.preview 
                                        ? announcementInfo.thumbnail.preview 
                                        : ($store.getters.base + 'public/Announcements/' + announcementInfo.thumbnail.name))
                                    : ($store.getters.base + 'public/Announcements/no-avatar.png')"
                            class="rounded-sm w-[130px] h-[185px] elevation-5 object-cover"
                            />
                        </div>



                        <div v-for="(image, index) in announcementInfo.images" 
                            :key="index"
                            class="d-flex justify-center items-center col-span-1 w-[130px] h-[185px] relative">

                            <v-img
                                :src="image.preview ? image.preview : ($store.getters.base + 'public/Announcements/' + image.name)"
                                alt="Preview"
                                cover
                                class="rounded-sm h-full w-full"
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
                                    (announcementInfo.thumbnail_id && announcementInfo.thumbnail_id === image.id) ||
                                    (announcementInfo.thumbnail_tempId && announcementInfo.thumbnail_tempId === image.tempId)
                                ) ? 'green-lighten-1' : 'primary'"
                                class="ma-2"
                                style="position: absolute; top: 0; right: 0;"
                                @click="setThumbnail(image)"
                            >
                                <v-icon size="15">
                                    {{
                                        (announcementInfo.thumbnail_id && announcementInfo.thumbnail_id === image.id) ||
                                        (announcementInfo.thumbnail_tempId && announcementInfo.thumbnail_tempId === image.tempId)
                                        ? 'mdi-star'
                                        : 'mdi-star-outline'
                                    }}
                                </v-icon>
                            </v-btn>
                        </div>


                        <div
                            class="custom-card d-flex justify-center items-center col-span-1 w-[130px] h-[185px] border-2 border-dashed"
                            @click="triggerFileInput"
                        >
                        <v-icon size="40">
                            mdi-plus
                        </v-icon>
                        </div>
                    </div>
                </div>

                <!-- Announcement Form -->
                <div class="d-flex flex-col justify-center items-center gap-5 h-auto w-full col-span-1">    
                    <!-- Announcement Title -->
                    <v-text-field
                    class="w-full text-lg"
                    v-model="announcementInfo.title"
                    label="Announcement Title"
                    variant="outlined"
                    required
                    ></v-text-field>
                    
                    <!-- Announcement Subtitle -->
                    <v-textarea
                    class="w-full text-lg"
                    v-model="announcementInfo.description"
                    label="Announcement Description"
                    variant="outlined"
                    required
                    ></v-textarea>

                    <div class="w-full">
                    <!-- WHEN -->
                        <v-date-input
                         v-model="selectedDates"
                        label="When"
                        class="text-xs font-italic relative bottom-0 right-0 w-full"
                        prepend-icon=""
                        prepend-inner-icon="$calendar"
                        variant="outlined"
                        multiple
                        />

                        <v-card class="w-full" v-if="announcementInfo.datetimes && announcementInfo.datetimes.length > 0">
                            <div v-for="(datetime, index) in announcementInfo.datetimes" :key="datetime.tempId || datetime.id || index"
                                class="border d-flex justify-center items-center px-4 py-2 ga-2">

                            <h4>{{ new Date(datetime.date).toLocaleDateString('en-US', { 
                                month: 'long', 
                                day: 'numeric', 
                                year: 'numeric' }) }}</h4>

                            <!-- Start Time -->
                            <v-menu
                                v-model="openMenus[index].start"
                                :close-on-content-click="false"
                                min-width="0"
                            >
                                <template v-slot:activator="{ props }">
                                <v-text-field
                                    v-bind="props"
                                    v-model="datetime.start"
                                    label="Start Time"
                                    hide-details="auto"
                                    readonly
                                />
                                </template>

                                <v-time-picker v-model="datetime.start" format="24hr" />
                            </v-menu>

                            <span class="mx-2">-</span>

                            <!-- End Time -->
                            <v-menu
                                v-model="openMenus[index].end"
                                :close-on-content-click="false"
                                min-width="0"
                            >
                                <template v-slot:activator="{ props }">
                                <v-text-field
                                    v-bind="props"
                                    v-model="datetime.end"
                                    label="End Time"
                                    hide-details="auto"
                                    readonly
                                />
                                </template>

                                <v-time-picker v-model="datetime.end" format="24hr" />
                            </v-menu>

                            <!-- Delete datetime button (only show if more than 1 datetime) -->
                            <v-btn 
                                v-if="announcementInfo.datetimes.length > 1"
                                icon 
                                size="small" 
                                color="error" 
                                @click="removeDatetime(index)"
                                class="ml-2"
                            >
                                <v-icon size="16">mdi-delete</v-icon>
                            </v-btn>

                            </div>
                        </v-card>
                        
                        <!-- Empty state when no datetimes -->
                        <v-card v-else class="w-full pa-4 text-center">
                            <p class="text-gray-500">Select dates above to add event times</p>
                        </v-card>
                    </div>

                    
                    <v-checkbox
                        v-model="announcementInfo.is_featured"
                        :true-value="1"
                        :false-value="0"
                        color="success"
                        label="Feature Announcement"
                    />

                </div>

                <!-- 5W and 1H Form -->
                <div class="d-flex flex-col justify-between items-center h-auto w-full col-span-1">
                    <!-- WHAT -->
                    <v-textarea
                    v-model="announcementInfo.what"
                    prepend-inner-icon="mdi-help-circle-outline"
                    class="w-full text-lg h-auto"
                    label="What"
                    name="what"
                    variant="outlined"
                    required
                    ></v-textarea>

                    <!-- WHO -->
                    <v-textarea
                    v-model="announcementInfo.who"
                    prepend-inner-icon="mdi-account"
                    class="w-full text-lg"
                    label="Who"
                    name="who"
                    variant="outlined"
                    required
                    ></v-textarea>

                    <!-- WHERE -->
                    <v-textarea
                    v-model="announcementInfo.where"
                    prepend-inner-icon="mdi-map-marker"
                    class="w-full text-lg"
                    label="Where"
                    name="where"
                    variant="outlined"
                    required
                    ></v-textarea>

                    <!-- WHY -->
                    <v-textarea
                    v-model="announcementInfo.why"
                    prepend-inner-icon="mdi-lightbulb-on-outline"
                    class="w-full text-lg"
                    label="Why"
                    name="why"
                    variant="outlined"
                    required
                    ></v-textarea>
                </div>

            </div>

            <!-- Action Buttons: Save/Discard -->
            <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center gap-10">
                <v-btn color="red-lighten-1" @click="discardChanges">DISCARD CHANGES</v-btn>
                <v-btn v-if="action === 'adding' || action === 'adding-main'" color="teal-lighten-1" @click="saveChanges">ADD ANNOUNCEMENT</v-btn>
                <v-btn v-if="action === 'updating' || action === 'updating-main'" color="teal-lighten-1" @click="saveChanges">UPDATE</v-btn>
            </v-card-actions>

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
    multiple
    @change="handleFileUpload"
    />

</template>

<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import { VTimePicker } from 'vuetify/labs/VTimePicker'
import $ from 'jquery';

export default {
    props: {
        announcement: Object,
        action: String
    },
    components: {
        VDateInput,
        VTimePicker
    },
    emits: ["close", "fetchInfo"],
    data() {
        return {
            initialAnnouncementInfo : {},
            announcementInfo: {},
            dialog: true,
            hasChanges: false,
            files: [],            // ✅ instead of single file
            filePreviews: [],     // ✅ multiple previews
            time: null,
            openMenus: [],
            tempIdCounter: 0,
        };
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
        selectedDates: {
            get() {
                // Always convert to Date object for v-date-input to work
                if(this.announcementInfo.datetimes && this.announcementInfo.datetimes.length > 0) {
                    return this.announcementInfo.datetimes.map(d => new Date(d.date));
                }
                return [];
            },
            set(newDates) {
                if (!newDates || newDates.length === 0) {
                    this.announcementInfo.datetimes = [];
                    this.openMenus = [];
                    return;
                }

                // Get existing datetimes by date to preserve times when dates are reselected
                const existingByDate = {};
                if (this.announcementInfo.datetimes) {
                    this.announcementInfo.datetimes.forEach(dt => {
                        existingByDate[dt.date] = dt;
                    });
                }

                // Create new datetimes array based on selected dates
                this.announcementInfo.datetimes = newDates.map((date) => {
                    const dateString = this.formatDate(date);
                    
                    // If this date already exists, keep the existing data
                    if (existingByDate[dateString]) {
                        return existingByDate[dateString];
                    }
                    
                    // Otherwise, create a new datetime entry
                    return {
                        id: null, // Will be set after saving to database
                        tempId: `temp_${++this.tempIdCounter}`, // Temporary ID for Vue reactivity
                        date: dateString,
                        start: '09:00:00', // Default start time
                        end: '17:00:00'    // Default end time
                    };
                });

                // Update openMenus to match the new datetimes length
                this.openMenus = this.announcementInfo.datetimes.map((_, i) => 
                    this.openMenus[i] || { start: false, end: false }
                );
            }
        }
    },
    methods: {
        removeDatetime(index) {
            this.announcementInfo.datetimes.splice(index, 1);
            this.openMenus.splice(index, 1);
        },

        setThumbnail(image) {
            this.announcementInfo.thumbnail = image;

            if (image.id) {
                this.announcementInfo.thumbnail_id = image.id; // DB image
                this.announcementInfo.thumbnail_tempId = null;
            } else {
                this.announcementInfo.thumbnail_id = null;
                this.announcementInfo.thumbnail_tempId = image.tempId; // New image
            }
        },

        initializeAnnouncementInfo() {
            if (!this.editing) {
                this.announcementInfo = {
                    title: '',
                    thumbnail_i: 0,
                    description: '',
                    what: '',
                    who: '',
                    where: '',
                    why: '',
                    is_featured: false,
                    datetimes: [],
                    images: []   // ✅ make sure images is always an array
                };
            }
        },


        saveChanges() {
            // Validate that we have at least one datetime
            if (!this.announcementInfo.datetimes || this.announcementInfo.datetimes.length === 0) {
                this.$store.commit('dialog/alert/show', {
                    title: 'Validation Error',
                    prompt: 'Please select at least one date for the announcement.',
                    color: 'error'
                });
                return;
            }

            // Validate that all datetimes have start and end times
            const invalidDatetimes = this.announcementInfo.datetimes.filter(dt => !dt.start || !dt.end);
            if (invalidDatetimes.length > 0) {
                this.$store.commit('dialog/alert/show', {
                    title: 'Validation Error',
                    prompt: 'Please set start and end times for all selected dates.',
                    color: 'error'
                });
                return;
            }
            
            // Depending on the action prop, either update or add an announcement.
            if (this.action === 'updating') {
                this.updateAnnouncement();
            } else if (this.action === 'adding') {
                this.addAnnouncement();
            }
            
            // Reset change flag and close the dialog
            this.hasChanges = false;
            this.dialog = false;
        },
        
        discardChanges() {
            this.announcementInfo = JSON.parse(JSON.stringify(this.initialAnnouncementInfo));

            this.file = null;
            this.filePreview = null;
            this.hasChanges = false;
        },
        
        closeForm() {
            this.$emit('close');
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },   
        handleFileUpload(event) {
            const selectedFiles = Array.from(event.target.files);
            this.announcementInfo.images = this.announcementInfo.images || [];

            selectedFiles.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.files.push(file);

                    this.announcementInfo.images.push({
                        tempId: `temp_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`, // ✅ unique temp id
                        name: file.name,
                        preview: e.target.result,
                        isNew: true
                    });
                };
                reader.readAsDataURL(file);
            });
        },

        removeImage(index) {
            // remove from files + previews
            this.files.splice(index, 1);
            this.filePreviews.splice(index, 1);

            // ✅ also remove from announcementInfo.images
            if (this.announcementInfo.images && this.announcementInfo.images[index]) {
                this.announcementInfo.images.splice(index, 1);
            }
        },
        addAnnouncement() {
            // Ensure is_featured is set (default to 0 if undefined)
            if (typeof this.announcementInfo.is_featured === 'undefined') {
                this.announcementInfo.is_featured = 0;
            }

            // Set the barangay ID from the store
            this.announcementInfo.barangay_id = this.$store.getters['auth/getBarangayId'];

            // ✅ Clean up datetime objects (normalize them for backend)
            const cleanDatetimes = this.announcementInfo.datetimes.map(dt => ({
                id: dt.id || null, // always send null for new entries
                date: dt.date,
                start: dt.start.length === 5 ? dt.start + ":00" : dt.start, // HH:mm:ss
                end: dt.end.length === 5 ? dt.end + ":00" : dt.end
            }));

            const announcementData = {
                ...this.announcementInfo,
                thumbnail_id: this.announcementInfo.thumbnail_id || null,
                thumbnail_tempId: this.announcementInfo.thumbnail_tempId || null,
                datetimes: cleanDatetimes,
                images: (this.announcementInfo.images || []).map(img => ({
                    id: img.id || null,
                    tempId: img.tempId || null,
                    name: img.name,
                    announcement_id: this.announcementInfo.id || null
                }))
            };

            // remove the thumbnail object (not needed for backend)
            delete announcementData.thumbnail;


            // Create FormData object
            const formData = new FormData();
            formData.append("announcementInfo", JSON.stringify(announcementData));

            // ✅ Handle file upload if provided
            if (this.files.length > 0) {
                this.files.forEach((file, i) => {
                    formData.append("files[]", file);  // ✅ backend should expect an array
                });
            }


            // AJAX request to backend
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=add-announcement`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                processData: false,
                contentType: false,
                data: formData,
                success: (data) => {
                    console.log("✅ Announcement added successfully", data);
                    this.$emit("fetchInfo", true);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("❌ Error adding announcement:", textStatus, errorThrown);
                },
                complete: () => {
                    this.showAddAnnouncementForm = false;
                    this.file = null;
                    this.filePreview = null;
                }
            });
        },

        updateAnnouncement() {
            // Clean up datetime objects - remove tempId for database operations
            const cleanDatetimes = this.announcementInfo.datetimes.map(dt => ({
                id: dt.id, // Keep existing IDs, will be null for new entries
                date: dt.date,
                start: dt.start,
                end: dt.end
            }));
            
            const announcementData = {
                ...this.announcementInfo,
                thumbnail_id: this.announcementInfo.thumbnail_id || null,
                thumbnail_tempId: this.announcementInfo.thumbnail_tempId || null,
                datetimes: cleanDatetimes,
                images: (this.announcementInfo.images || []).map(img => ({
                    id: img.id || null,
                    tempId: img.tempId || null,
                    name: img.name,
                    announcement_id: this.announcementInfo.id || null
                }))
            };

            // remove the thumbnail object (not needed for backend)
            delete announcementData.thumbnail;


            
            const formData = new FormData();
            formData.append("announcementInfo", JSON.stringify(announcementData));

            if (this.files.length > 0) {
                this.files.forEach((file, i) => {
                    formData.append("files[]", file);  // ✅ backend should expect an array
                });
            }

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
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error updating announcement:", textStatus, errorThrown);
                },
                complete: () => {
                    this.showAddAnnouncementForm = false;
                    this.file = null;
                    this.filePreview = null;
                    this.$emit('fetchInfo', true)
                }
            });
        },
        
        formatDate(date) {
            if (!date) return "";
            const d = new Date(date);
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const day = String(d.getDate()).padStart(2, "0");
            return `${d.getFullYear()}-${month}-${day}`;  // ✅ always YYYY-MM-DD
        },


        removeImage(index) {
            if (this.announcementInfo.images && this.announcementInfo.images[index]) {
                const removedImage = this.announcementInfo.images[index];

                // Remove from announcementInfo.images
                this.announcementInfo.images.splice(index, 1);

                // If it's a newly added file, also remove it from files[] by tempId
                if (removedImage.tempId) {
                    this.files = this.files.filter(f => f.name !== removedImage.name);
                }
            }
        }
    },
    watch: {
        announcement: {
            immediate: true,
            handler(newVal) {
            if (newVal && Object.keys(newVal).length > 0) {
                this.announcementInfo = JSON.parse(JSON.stringify(newVal));

                // ✅ find the thumbnail image
                if (this.announcementInfo.thumbnail_id && this.announcementInfo.images) {
                const thumb = this.announcementInfo.images.find(
                    img => img.id === this.announcementInfo.thumbnail_id
                );
                this.announcementInfo.thumbnail = thumb || null;
                }
            } else {
                this.initializeAnnouncementInfo();
            }

            this.initialAnnouncementInfo = JSON.parse(JSON.stringify(this.announcementInfo));
            },
            deep: true
        },

        // Watch for any changes in announcementInfo to update the hasChanges flag.
        announcementInfo: {
            handler(newVal) {
                this.hasChanges =
                    JSON.stringify(newVal) !== JSON.stringify(this.initialAnnouncementInfo);
            },
            deep: true
        },
        "announcementInfo.datetimes": {
            handler(newVal) {
                if (newVal) {
                    this.openMenus = newVal.map((_, i) => this.openMenus[i] || { start: false, end: false });
                }
            },
            deep: true,
            immediate: true
        }
    },
    created() {
        // Initialize for new announcements
        if (!this.editing && (!this.announcement || Object.keys(this.announcement).length === 0)) {
            this.initializeAnnouncementInfo();
            this.initialAnnouncementInfo = JSON.parse(JSON.stringify(this.announcementInfo));
        }
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