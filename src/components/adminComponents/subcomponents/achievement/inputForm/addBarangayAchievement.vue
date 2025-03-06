<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  year: String,
  month: String,
  barangayId: Number
});

const dialog = ref(false);
const barangayAchievement = ref({
    barangay_id: props.barangayId,
    img: 'ex.jpg',
    title: '',
    subtitle: '',
    info: '',
    date: new Date(props.year, props.month, 0)
});

const submitAchievement = async (newAchievement) => {
  try {
        const response = await axios.post(
        'http://localhost/youth/app/api/BarangayAchievement.php',{
            barangay_id: newAchievement.barangay_id,
            title: newAchievement.title,
            subtitle: newAchievement.subtitle,
            info: newAchievement.info,
            img: newAchievement.img,  // Ensure this is a valid image URL or Base64 string
            date: newAchievement.date
        }
        );
        if (response.data.success) {
            console.log('Achievement updated successfully:', response.data.message);
            emit('achievementAdded');
        } else {
            console.error('Update failed:', response.data.error);
        }
    } catch (error) {
        console.error('Error updating achievement:', error);
    }

    console.log("Submitted Data:", newAchievement.value);
    dialog.value = false; // Close dialog after submission
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            imageUrl.value = reader.result;
        };
        reader.readAsDataURL(file);
        // barangayAchievement.value.img = file;
    }
};

const emit = defineEmits(['achievementAdded']);
</script>

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
                                <v-text-field 
                                    v-model="barangayAchievement.title" 
                                    label="Barangay Achievement Title" 
                                    required>
                                </v-text-field>
                                <v-text-field 
                                    v-model="barangayAchievement.subtitle" 
                                    label="Barangay Achievement Subtitle" 
                                    required>
                                </v-text-field>
                                <v-textarea v-model="barangayAchievement.info" label="Info">
                                </v-textarea>
                            </article>
                        </v-card>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="grey" @click="dialog = false">Cancel</v-btn>
                    <v-btn color="primary" @click="submitAchievement(barangayAchievement)">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

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
