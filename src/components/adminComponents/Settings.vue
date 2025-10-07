<script>
import $ from 'jquery';

export default {
    data() {
        return {
            passwordInfos : {},
            authorizedAccounts: [],
            newAccountDialog: false
        }
    },
    methods: {
        getAuthorizedAccounts() {
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=authorized-accounts`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: {'X-CSRF-Token' : document.querySelector('meta[name="csrf-token"]').content},
                data : {barangayId: this.$store.getters['auth/getBarangayId']},

                // Callback Functions
                success: (data) => {
                    this.authorizedAccounts = data.data
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
                complete: () => {}
            })
        },
        changePassword() {
            const passwordInfo = new FormData();
            passwordInfo.append('barangay_id', this.$store.getters['auth/getBarangayId']);
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
        },
        loginWithGoogle() {
            const clientId = "144092227095-2o4leroklngkidvlum4s8vlguchcc4av.apps.googleusercontent.com";
            const provider = "google";
            const redirectUri = "http://localhost:5173/admin/san-francisco/settings";
            const scope = "openid email profile";
            const responseType = "code";

            const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=${responseType}&state=${provider}&scope=${encodeURIComponent(scope)}`;

            window.location.href = authUrl;  
        },
    },
    created() {
        this.getAuthorizedAccounts();
    },
    mounted() {
        // 🎯 Handle OAuth redirect with ?code=...
        const params = new URLSearchParams(window.location.search);
        const code = params.get("code");
        const state = params.get("state");

        if(code) {
        $.ajax({
            url: `${this.$store.getters["api_base"]}?e=auth&a=bound-account-${state}`,
            type: "POST",
            xhrFields: { withCredentials: true },
            headers: {
            "X-CSRF-Token": document.querySelector("meta[name='csrf-token']").content,
            },
            data: { code },
            success: (res) => {
            if (res.success) {
                this.$store.commit("auth/setUser", res.data);
                const barangaySlug = res?.data?.barangay?.slug;
                if (barangaySlug) {
                this.$router.replace({ name: "admin-dashboard", params: { barangaySlug } });
                } else {
                this.$router.replace({ name: "admin-dashboard" });
                }
            } else {
                console.error("OAuth failed:", res);
            }
            },
            error: (xhr, status, err) => {
            console.error("OAuth request error:", err);
            },
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
    <v-container class="d-flex flex-col justify-center items-center ga-15">

        <!-- Change Password -->
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

        <!-- Accounts Bound to Barangay Account -->
         <v-card class="w-[70%] d-flex flex-col justify-center items-center pa-15 ga-10">
            <!-- Title Section -->
            <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-5">
                <v-icon size="40">mdi-account-multiple</v-icon>
                <h2 class="font-extrabold text-2xl">BOUND ACCOUNTS</h2>
                <v-icon size="40">mdi-account-multiple</v-icon>
            </v-card-title>


            <div class="d-flex flex-wrap justify-evenly ga-10">
                <div class="d-flex flex-col items-center ga-5">
                    <!-- Provider Title Section -->
                    <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-3">
                        <v-img height="50" :src="($store.getters.base + 'public/Facebook_Logo_(2019).png')"/>
                        &
                        <v-img height="40" :src="($store.getters.base + 'public/google-brand-color.svg')"/>
                    </v-card-title>

                    <v-card 
                    v-for="account in authorizedAccounts" :key="(index, account)"
                    class="d-flex flex-col justify-center items-center elevation-10 pa-5 pb-0 ga-3 border border-orange-300">
                        <!-- Profile Image of the Account -->
                        <div class="d-flex justify-center items-center ga-5">
                            <v-avatar size="80">
                                    <v-img src="https://lh3.googleusercontent.com/a/ACg8ocJwzlH7cWcj_4lLhQcdQFqW9fKMp05LlJqovsGYgZ45MhJM820=s96-c"></v-img>
                            </v-avatar>

                            <!-- Details of the Account -->
                            <div>
                                <h4>Name: {{ account.name }}</h4>
                                <h4>Email: {{ account.email }}</h4>
                                <h4 class="capitalize">Account Provider: {{ account.provider }}</h4>
                            </div>
                        </div>

                        <v-card-actions class="border-t w-[90%] d-flex justify-evenly items-center">
                            <v-btn color="red">DELETE</v-btn>
                        </v-card-actions>
                    </v-card>
                </div>
            </div>

            <v-btn 
            class="border"
            @click="newAccountDialog = true">
                BOUND NEW ACCOUNT
            </v-btn>

            <v-dialog 
            :height="auto"
            :width="450"
            v-model=newAccountDialog>
                <v-card class="d-flex justify-center items-center py-10 rounded-4xl">
                    <h1 class="font-black">BOUND NEW ACCOUNT</h1>
                    <div class="h-auto d-flex flex-col ga-2 py-5">
                        <v-btn size="large" @click="loginWithGoogle">
                        <div class="d-flex justify-center items-center ga-3">
                            <v-avatar size="30" :image="$store.getters['base'] + 'public/google_logo.svg'" />
                            <span class="text-sm">Google Account</span>
                        </div>
                        </v-btn>
                    </div>
                </v-card>
            </v-dialog>

         </v-card>
    </v-container>
</template>

<style scoped>
</style>