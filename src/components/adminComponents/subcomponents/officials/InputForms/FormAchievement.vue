<template>
    <v-dialog width="900px" max-height="90vh" v-model="dialog" persistent>
        <v-card elevation="5" 
            class="d-flex flex-col items-center pa-10 gap-10 "
            >
            <div class="w-[60%] d-flex justify-center items-center relative">
                <v-img 
                :src="filePreview || (achievementInfo.img? ($store.getters.base + 'public/achievements/' + achievementInfo.img) : ($store.getters.base + 'public/exx.jpg'))"
                alt="" class="elevation-5 rounded-lg"></v-img>

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
            <article class="d-flex flex-col items-start w-[90%]">
                <v-text-field
                    class="w-full text-lg uppercase "
                    v-model="achievementInfo.title"
                    label="Achievement Title"
                    variant="outlined"
                    required>
                </v-text-field>

                <v-text-field
                    class="w-full text-lg uppercase "
                    v-model="achievementInfo.subtitle"
                    label="Achievement Subtitle"
                    variant="outlined"
                    required>
                </v-text-field>

                
                <v-textarea
                    class="w-full text-lg uppercase"
                    v-model="achievementInfo.info"
                    label="Achievement Info"
                    required
                    auto-grow
                    rows="1"
                    variant="outlined"
                ></v-textarea>

                <v-date-input
                    v-model="achievementInfo.date"
                    label="Select a date"
                    class="text-xs font-italic relative bottom-0 right-0 w-full"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="solo"
                />
            </article>

            <!-- Action Buttons -->
            <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center ga-10">
                <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
                <v-btn v-if="action === 'adding'" color="teal-lighten-1"  @click="saveChanges">Add Achievement</v-btn>
                <v-btn v-if="action === 'updating'" color="teal-lighten-1" @click="saveChanges">Save Changes</v-btn>
            </v-card-actions>
        </v-card>

        <v-card-actions class="absolute top-0 right-0 pa-5">
            <v-btn icon color="error" @click="closeForm">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-card-actions>
    </v-dialog>
</template>


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
            dialog: true,
            initialAchievementInfo: {},
            achievementInfo: {},
            hasChanges: false,
            file: null,
            filePreview: null,
        };
    },
    methods: {
        saveChanges() {
            this.achievementInfo.date = this.formatDate(this.achievementInfo.date);
            if(this.action === 'updating') {
                this.updateAchievement();
            } 
            else if(this.action === 'adding') {
                this.addAchievement();
            }
            this.hasChanges = false;
            this.dialog = false;
        },
        discardChanges() {
            this.achievementInfo = { ...this.initialAchievementInfo };
            this.filePreview = null;
            this.hasChanges = false;
        },
        updateDate(newDate) {
            this.achievementInfo.date = newDate;
        },
        closeForm() {
            this.$emit('close');
        },
        formatDate(date) {
            if (!date) return "";
            const d = new Date(date);
            return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.file = file;
                // Create a file preview URL
                const reader = new FileReader();
                reader.onload = (e) => {
                this.filePreview = e.target.result; // store the base64 preview
                // Optionally, store the filename in personalInfo.img for later use
                this.achievementInfo.img = file.name;
                };
                reader.readAsDataURL(file);
            }
        },
        updateAchievement() {
            const formData = new FormData();
            formData.append("achievementInfo", JSON.stringify(this.achievementInfo));
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
                // Convert date strings back to Date objects for the v-date-input
                this.achievementInfo.date = new Date(this.achievementInfo.date);

                // Update initial data so all references are in sync
                this.initialAchievementInfo = { ...this.achievementInfo };
                this.hasChanges = false;
                // Optionally clear file preview if upload is complete
                this.filePreview = null;
                this.$emit("fetchAchievement", true);
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
                console.log("Data has been Added successfully", data);
                // Convert date strings back to Date objects for the v-date-input
                this.achievementInfo.date = new Date(this.achievementInfo.date);

                // Update initial data so all references are in sync
                this.initialAchievementInfo = { ...this.achievementInfo };
                this.hasChanges = false;
                // Optionally clear file preview if upload is complete
                this.filePreview = null;
                this.$emit("fetchAchievement", true);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                }
            });
        }
    },
    watch : {
        achievement: {
            immediate: true,
            handler(newVal) {
                this.achievementInfo = { ...newVal };
                if (newVal.date) this.achievementInfo.date = new Date(newVal.date);
                this.initialAchievementInfo = { ...this.achievementInfo };
            },
            deep: true
        },
        achievementInfo: {
            handler(newVal) {
                this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialAchievementInfo);
            },
            deep: true
        }
    },
    components: {
        VDateInput
    }
};
</script>

<style scoped>
.add-ebg-button {
    border-radius: .5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    margin: auto;
    font-size: .7rem;
}


/* Floating Upload Icon */
.upload-icon {
  position: absolute;
  bottom: 0;
  right: 0;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  width: 48px;
}
</style>