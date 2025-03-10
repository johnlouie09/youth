<template>
    <v-container>
        <v-btn class="add-ebg-button" @click="dialog = true">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD NEW BARANGAY ACHIEVEMENT</span>
        </v-btn>

        <v-dialog max-width="700px" class="dialog-padding" v-model="dialog" persistent>
            <v-card>
                <v-card-title class="text-h5 d-flex justify-center">
                    EDIT BARANGAY ACHIEVEMENT
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-card elevation="5" class="form-container">
                            <label class="image-upload" @click="$refs.fileInput.click()">
                                <input type="file" ref="fileInput" accept="image/*" @change="handleImageUpload" hidden>
                                <img :src="barangayAchievementUpdate.img" alt="Uploaded Image">
                            </label>

                            <article>
                                <v-text-field 
                                    v-model="barangayAchievementUpdate.title" 
                                    label="Barangay Achievement Title" 
                                    required>
                                </v-text-field>
                                <v-text-field 
                                    v-model="barangayAchievementUpdate.subtitle" 
                                    label="Barangay Achievement Subtitle" 
                                    required>
                                </v-text-field>
                                <v-textarea v-model="barangayAchievementUpdate.info" label="Info">
                                </v-textarea>
                            </article>
                            <v-btn color="error" class="ma-auto" @click="closeForm" width="30%">Cancel</v-btn>

                        </v-card>
                    </v-form>


                    <!-- Action Buttons -->
                    <v-card-actions v-if="hasChanges" class="actions">
                        <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                        <v-btn color="primary" @click="updateAchievement(barangayAchievementUpdate)">Save Changes</v-btn>
                    </v-card-actions>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        barangayAchievement: Object
    },
    data() {
        return {
            dialog: true,
            initialBarangayAchievement: {
                id: this.barangayAchievement.id,
                img: this.barangayAchievement.img,
                title: this.barangayAchievement.title,
                subtitle: this.barangayAchievement.subtitle,
                info: this.barangayAchievement.info,
                date: this.barangayAchievement.date
            },
            barangayAchievementUpdate: {},
            hasChanges: false
        };
    },
    watch: {
        barangayAchievementUpdate: {
            deep: true,
            handler(newVal) {
                this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialBarangayAchievement);
            }
        }
    },
    created() {
        this.resetForm();
    },
    methods: {
        async updateAchievement() {
            try {
                const response = await axios.put('http://localhost/youth/app/api/BarangayAchievement.php', {
                    id: this.barangayAchievementUpdate.id,
                    title: this.barangayAchievementUpdate.title,
                    subtitle: this.barangayAchievementUpdate.subtitle,
                    info: this.barangayAchievementUpdate.info,
                    img: this.barangayAchievementUpdate.img,
                    date: this.barangayAchievementUpdate.date
                });

                if (response.data.success) {
                    console.log('Achievement updated successfully:', response.data.message);
                    this.$emit('achievementUpdated');
                    this.$emit('close');
                } else {
                    console.error('Update failed:', response.data.error);
                }
            } catch (error) {
                console.error('Error updating achievement:', error);
            }
        },
        discardChanges() {
            this.resetForm();
            this.hasChanges = false;
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.barangayAchievementUpdate.img = URL.createObjectURL(file);
            }
        },
        closeForm() {
            this.$emit('close');
        },
        resetForm() {
            this.barangayAchievementUpdate = JSON.parse(JSON.stringify(this.initialBarangayAchievement));
        }
    }
};
</script>


<style scoped>
.v-dialog {
    backdrop-filter: blur(5px);
}

.dialog-padding .v-card {
    padding: 2rem;
    border-radius: 1rem;
    max-height: 100vh;
}

.add-ebg-button {
    border-radius: .5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    margin: auto;
    font-size: .7rem;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.image-upload {
    width: 80%;
    border: 2px dashed #ccc;
    border-radius: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    position: relative;
    margin: auto;
}

.image-upload img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.upload-icon {
    font-size: 50px;
    color: #aaa;
}

/* Buttons */
.actions {
    display: flex;
    justify-content: space-evenly;
    width: 100%;
    margin-top: 1rem;
}
</style>
