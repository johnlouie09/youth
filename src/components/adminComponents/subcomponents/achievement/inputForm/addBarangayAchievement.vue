<template>
    <v-container>
        <v-btn class="add-ebg-button" @click="dialog = true">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD NEW BARANGAY ACHIEVEMENT</span>
        </v-btn>

        <v-dialog max-width="700px" class="dialog-padding" v-model="dialog">
            <v-card>
                <v-card-title class="text-h5 d-flex justify-center">
                    NEW BARANGAY ACHIEVEMENT
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-card elevation="5" class="form-container">
                            <label class="image-upload" @click="$refs.fileInput.click()">
                                <input type="file" ref="fileInput" accept="image/*" @change="handleImageUpload" hidden>
                                <v-icon class="upload-icon">mdi-camera-plus</v-icon>
                            </label>

                            <article>
                                <v-text-field v-model="barangayAchievement.title" label="Barangay Achievement Title" required></v-text-field>
                                <v-text-field v-model="barangayAchievement.subtitle" label="Barangay Achievement Subtitle" required></v-text-field>
                                <v-textarea v-model="barangayAchievement.info" label="Info"></v-textarea>
                            </article>
                        </v-card>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="grey" @click="dialog = false">Cancel</v-btn>
                    <v-btn color="primary" @click="submitAchievement">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        year: String,
        month: String,
        barangayId: Number
    },
    data() {
        return {
            dialog: false,
            barangayAchievement: {
                barangay_id: this.barangayId,
                img: 'ex.jpg',
                title: '',
                subtitle: '',
                info: '',
                date: new Date(this.year, this.month, 0)
            }
        };
    },
    methods: {
        async submitAchievement() {
            try {
                const response = await axios.post(
                    'http://localhost/youth/app/api/BarangayAchievement.php',
                    {
                        barangay_id: this.barangayAchievement.barangay_id,
                        title: this.barangayAchievement.title,
                        subtitle: this.barangayAchievement.subtitle,
                        info: this.barangayAchievement.info,
                        img: this.barangayAchievement.img,
                        date: this.barangayAchievement.date
                    }
                );

                if (response.data.success) {
                    console.log('Achievement updated successfully:', response.data.message);
                    this.$emit('achievementAdded');
                } else {
                    console.error('Update failed:', response.data.error);
                }
            } catch (error) {
                console.error('Error updating achievement:', error);
            }

            console.log('Submitted Data:', this.barangayAchievement);
            this.dialog = false;
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.barangayAchievement.img = reader.result;
                };
                reader.readAsDataURL(file);
            }
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
    padding: 2rem;
}

.image-upload {
    width: 100%;
    border: 2px dashed #ccc;
    border-radius: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    position: relative;
    padding: 4rem;
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
</style>