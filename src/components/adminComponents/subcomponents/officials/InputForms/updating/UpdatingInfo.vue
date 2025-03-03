<script setup>
import { ref, watch } from 'vue';

const dialog = ref(true);
const props = defineProps({
    info: Object
});

const initialOtherInfo = {
    title: props.info.title,
    icon: props.info.icon,
    details: [...props.info.details],
};

const otherInfo = ref(JSON.parse(JSON.stringify(initialOtherInfo)));
const hasChanges = ref(false);
const newDetail = ref("");

watch(otherInfo, (newVal) => {
    hasChanges.value = JSON.stringify(newVal) !== JSON.stringify(initialOtherInfo);
}, { deep: true });

const saveChanges = () => {
    Object.assign(initialOtherInfo, JSON.parse(JSON.stringify(otherInfo.value)));
    hasChanges.value = false;
    emit('close');
};

const discardChanges = () => {
    otherInfo.value = JSON.parse(JSON.stringify(initialOtherInfo));
    hasChanges.value = false;
    newDetail.value = "";
};

const fileInput = ref(null);
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        otherInfo.value.icon = URL.createObjectURL(file);
    }
};

const triggerFileInput = () => {
    fileInput.value.click();
};

const addDetail = () => {
    if (newDetail.value.trim() !== "") {
        otherInfo.value.details.push(newDetail.value.trim());
        newDetail.value = "";
    }
};

const removeDetail = (index) => {
    otherInfo.value.details.splice(index, 1);
};

const emit = defineEmits(['close']);
const closeForm = () => {
    emit('close');
};
</script>

<template>
    <v-dialog v-model="dialog" max-width="900px" persistent="">
        <v-card class="info-card">
            <v-text-field v-model="otherInfo.title" label="Title" clearable></v-text-field>

            <v-card-text class="card-body">
                <div class="image-container">
                    <v-icon :icon="otherInfo.icon" size="80" class="profile-image"></v-icon>
                    <v-btn class="upload-icon" icon @click="triggerFileInput">
                        <v-icon size="15">mdi-camera</v-icon>
                    </v-btn>
                    <input ref="fileInput" type="file" accept="image/*" class="hidden-file-input" @change="handleFileUpload">
                </div>

                <div class="details-container overflow-y-auto">
                    <v-text-field 
                        v-for="(detail, i) in otherInfo.details" 
                        :key="i"
                        v-model="otherInfo.details[i]"
                        clearable
                    >
                        <template v-slot:append>
                            <v-btn icon="mdi-delete" @click="removeDetail(i)" color="red" size="30"></v-btn>
                        </template>
                    </v-text-field>

                    <v-text-field v-model="newDetail" label="New Detail" clearable></v-text-field>
                    <v-btn block color="blue" variant="text" @click="addDetail">+ Add</v-btn>
                </div>
            </v-card-text>

            <v-btn color="error" width="30%" class="mx-auto d-block" @click="closeForm">Cancel</v-btn>
            <v-card-actions v-if="hasChanges" class="actions mx-auto d-block">
                <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                <v-btn color="primary" @click="saveChanges">Save Changes</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
/* Make scrollbar small */
::-webkit-scrollbar {
    width: 6px;  /* Set the scrollbar width */
    height: 6px; /* Set the scrollbar height (for horizontal scrollbars) */
}

/* Scrollbar track (background) */
::-webkit-scrollbar-track {
    background: #1e1e1e;  /* Dark background */
    border-radius: 10px;
}

/* Scrollbar thumb (draggable part) */
::-webkit-scrollbar-thumb {
    background: #555;  /* Gray thumb */
    border-radius: 10px;
}

/* Scrollbar thumb on hover */
::-webkit-scrollbar-thumb:hover {
    background: #888;  /* Lighter gray on hover */
}

.v-dialog {
    width: 30%;
}

.info-card {
    border-radius: 0.5rem;
    box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    padding: 2rem;
    gap: 1rem;

}
.card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-height: 60vh;
}
.image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}
.profile-image {
    width: 80px;
    height: 80px;
    padding: 1rem;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid black;
}
.upload-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 2rem;
    height: 2rem;
}
.hidden-file-input {
    display: none;
}
.details-container {
    width: 100%;
    max-height: 70vh;
    padding-right: 1rem;
}
</style>