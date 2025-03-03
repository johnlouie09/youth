<script setup>
import { ref, computed, watch} from 'vue';
import { VDateInput } from 'vuetify/lib/labs/components.mjs';

const props = defineProps({
    achievement: Object
})

const dialog = ref(true);

// Initial Education Data
const initialAchievementInfo = {
    title: props.achievement.title,
    date: props.achievement.date,
};

// Reactive state for form
const achievementInfo = ref({ ...initialAchievementInfo });
const hasChanges = ref(false);

// Watch for changes to enable the Save/Discard buttons
watch(achievementInfo, (newVal) => {
    hasChanges.value = JSON.stringify(newVal) !== JSON.stringify(initialAchievementInfo);
}, { deep: true });

// Save changes and update initial values
const saveChanges = () => {
    Object.assign(initialAchievementInfo, { ...achievementInfo.value });
    hasChanges.value = false;
    emit('close');
};

// Discard changes and reset form
const discardChanges = () => {
    achievementInfo.value = { ...initialAchievementInfo };
    hasChanges.value = false;
};

const updateDate = (newDate) => {
    achievementInfo.value.date = newDate;
};


const emit = defineEmits(['close']); // Define an event for closing
const closeForm = () => {
    emit('close'); // Emit event when closing
};
</script>

<template>
    <v-dialog max-width="900px" class="dialog-padding" v-model="dialog" persistent>
        <v-card class="card">
            <v-form ref="form">
                <v-text-field 
                    v-model="achievementInfo.title" 
                    label="Achievement Title" 
                    required>
                </v-text-field>

                <!-- Month & Year Picker -->
                <v-date-input
                    v-model="achievementInfo.date"
                    label="Select a date"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="solo"
                    @update:modelValue="updateDate"
                />
            </v-form>

            <v-btn color="error" @click="closeForm" width="30%">Cancel</v-btn>

            <!-- Action Buttons -->
            <v-card-actions v-if="hasChanges" class="actions">
                <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                <v-btn color="primary" @click="saveChanges">Save Changes</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


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

.card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem;
    gap: 2rem;
    padding: 2rem;
    border-radius: 1rem;
}

.card .v-form {
    width: 100%;
}

</style>
