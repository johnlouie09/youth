<script>
import $ from 'jquery';
import { error } from 'jquery';
import { type } from 'jquery';

export default {
    data() {
        return {
            passwordInfos : {}
        }
    },
    methods: {
    changePassword() {
        const passwordInfo = new FormData();
        passwordInfo.append('sk_official_id', this.$store.getters['auth/getSkOfficialId']);
        passwordInfo.append('passwordInfo', JSON.stringify(this.passwordInfos)); // ✅ stringify object

        $.ajax({
            url: `${this.$store.getters['api_base']}?e=barangay&a=change-password`, // ✅ fixed endpoint
            type: 'POST',
            xhrFields: { withCredentials: true },
            data: passwordInfo,
            processData: false, // ✅ important for FormData
            contentType: false, // ✅ important for FormData
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            },
            success: (data) => {
                console.log('Password successfully changed');
                console.log(data);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
                let errorMsg = "An error occurred while processing your request.";
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMsg = jqXHR.responseJSON.message;
                } else if (jqXHR.responseText) {
                    errorMsg = jqXHR.responseText;
                }
                alert(errorMsg); // ✅ show error feedback to user
            }
        });
    }

    },
    computed : {
        hasChanges() {
            if((this.passwordInfos.oldPassword != null) && (this.passwordInfos.newPassword === this.passwordInfos.reEnteredPassword)) {
                return true;
            }
            else {
                return false;
            }
        }
    }
}
</script>

<template>
    <v-container class="d-flex flex-col justify-center items-center">
        <v-card class="w-[500px] d-flex flex-col justify-center items-center pa-10 rounded-2xl">
            <!-- Title Section -->
            <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-5">
            <v-icon size="40">mdi-key-change</v-icon>
            <h2 class="font-extrabold text-xl">CHANGE PASSWORD</h2>
            <v-icon size="40">mdi-key-change</v-icon>
            </v-card-title>

            <!-- Password -->
            <v-text-field
            v-model="passwordInfos.oldPassword"
            class="w-full"
            label="Password"
            type="password"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            density="comfortable"
            :error-messages="passwordError"
            />

            <!-- New Password -->
            <v-text-field
            v-model="passwordInfos.newPassword"
            class="w-full"
            label="New Password"
            type="password"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            density="comfortable"
            :error-messages="passwordError"
            />

            <!-- Re-enter New Password -->
            <v-text-field
            v-model="passwordInfos.reEnteredPassword"
            class="w-full"
            label="Re-enter New Password"
            type="password"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            density="comfortable"
            :error-messages="passwordError"
            />

            <!-- Action Buttons: Save/Discard -->
            <v-card-actions 
            v-if="hasChanges"
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;">
                <v-btn color="red-lighten-1" @click="passwordInfos = {}">Discard</v-btn>
                <v-btn color="teal-lighten-1" @click="changePassword">Save Password</v-btn>
            </v-card-actions>

        </v-card>
    </v-container>
</template>

<style scoped>
</style>