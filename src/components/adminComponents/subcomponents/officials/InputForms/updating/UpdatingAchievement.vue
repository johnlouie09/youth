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


<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';

export default {
    props: {
        achievement: Object
    },
    data() {
        return {
            dialog: true,
            initialAchievementInfo: {
                title: this.achievement.title,
                date: this.achievement.date,
            },
            achievementInfo: {
                title: this.achievement.title,
                date: this.achievement.date,
            },
            hasChanges: false
        };
    },
    watch: {
        achievementInfo: {
            handler(newVal) {
                this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialAchievementInfo);
            },
            deep: true
        }
    },
    methods: {
        saveChanges() {
            Object.assign(this.initialAchievementInfo, { ...this.achievementInfo });
            this.hasChanges = false;
            this.$emit('close');
        },
        discardChanges() {
            this.achievementInfo = { ...this.initialAchievementInfo };
            this.hasChanges = false;
        },
        updateDate(newDate) {
            this.achievementInfo.date = newDate;
        },
        closeForm() {
            this.$emit('close');
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