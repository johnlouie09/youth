<template>
    <v-dialog v-model="isDialogOpen" max-width="1000px" height="90vh" persistent>
        <v-card style="border-radius: 1rem;" border="primary lg">
            <v-card-title class="d-flex flex-col align-center justify-center pa-10 ga-5">
                <v-avatar
                    :image="officialInfos.personalInfo.img? ($store.getters.base + '/OfficialImages/' + officialInfos.personalInfo?.img) : '/OfficialImages/no-avatar.png'"
                    size="200"
                    cover
                    alt="SK Logo"
                    class="rounded-circle"
                ></v-avatar>
                <div class="text-wrap text-center">
                    <h2 class="text-xl font-black uppercase">
                        {{ officialInfos.personalInfo?.full_name || '' }}
                    </h2>
                    <span class="text-base font-bold pa-0 w-full">
                        {{ officialInfos.personalInfo?.position.toUpperCase() || '' }}
                    </span>
                </div>
            </v-card-title>

            <!-- Icon Tab Bar with active state -->
            <v-sheet class="d-flex justify-evenly ">
                <v-btn
                    icon
                    :class="{ 'active-tab': activeTab === 'profile' }"
                    @click="activeTab = 'profile'">
                    <v-icon>mdi-account</v-icon>
                </v-btn>
                <v-btn
                    icon
                    :class="{ 'active-tab': activeTab === 'education' }"
                    @click="activeTab = 'education'">
                    <v-icon>mdi-school</v-icon>
                </v-btn>
                <v-btn
                    icon
                    :class="{ 'active-tab': activeTab === 'achievements' }"
                    @click="activeTab = 'achievements'">
                    <v-icon>mdi-trophy</v-icon>
                </v-btn>
            </v-sheet>

            <v-divider class="mt-5"></v-divider>

            <!-- Error Alert if fetch fails -->
            <v-alert v-if="errorMessage" type="error" class="mx-5">{{ errorMessage }}</v-alert>

            <!-- Content Sections -->
            <v-container style="position: relative; overflow-y: auto; display: flex; justify-content: center; height: 100%; padding: 0;">
                <!-- Profile Information Section -->
                <v-sheet v-if="activeTab === 'profile'" class="w-full rounded-lg overflow-auto">
                    <v-card-title class="text-center sticky z-10 top-0 pa-0 pt-5 bg-inherit">
                        <v-icon class="mr-2">mdi-account</v-icon>PROFILE INFORMATION
                        <v-divider class="mt-5"></v-divider>
                    </v-card-title>

                    <v-container class="d-flex flex-col justify-start items-center py-5 px-10 h-full">
                        <v-sheet class="d-flex w-full">
                            <v-card class="d-flex flex-row justify-start items-center w-full px-5 py-1">
                                <v-icon>mdi-email</v-icon>
                                <v-card-item>
                                    <p>{{ officialInfos.personalInfo?.email || 'N/A' }}</p>
                                    <h5 class="text-xs font-bold">Email</h5>
                                </v-card-item>
                            </v-card>
                            <v-card class="d-flex flex-row justify-start items-center w-full px-5 py-1">
                                <v-icon>mdi-phone</v-icon>
                                <v-card-item>
                                    <p>{{ officialInfos.personalInfo?.contact_number || 'N/A' }}</p>
                                    <h5 class="text-xs font-bold">Mobile</h5>
                                </v-card-item>
                            </v-card>
                        </v-sheet>
                        <v-card class="d-flex flex-row justify-start items-center w-full px-5 py-1 mb-5">
                            <v-icon>mdi-cake-variant</v-icon>
                            <v-card-item>
                                <p class="text-base">{{ formatDate(officialInfos.personalInfo?.birthday) || 'N/A' }}</p>
                                <h5 class="text-xs font-bold">Birthdate</h5>
                            </v-card-item>
                        </v-card>

                        <div class="d-flex w-full justify-center items-center pb-5">
                            <div class="d-flex flex-col items-center justify-center w-[50%] pa-2 elevation-5">
                                <h4 class="text-lg font-bold">TERM START</h4>
                                <span>{{ formatDate(officialInfos.personalInfo?.term_start) || 'N/A' }}</span>
                            </div>
                            <div class="d-flex flex-col items-center justify-center w-[50%] pa-2 elevation-5">
                                <h4 class="text-lg font-bold">TERM END</h4>
                                <span>{{ formatDate(officialInfos.personalInfo?.term_end) || 'N/A' }}</span>
                            </div>
                        </div>
                        <p class="d-block w-[100%] text-center text-xl text-grey font-italic motto-text relative bottom-0 right-0">"{{ officialInfos.personalInfo?.motto || 'No Motto Available' }}"</p>
                    </v-container>
                </v-sheet>

                <!-- Educational Backgrounds Section -->
                <v-sheet v-if="activeTab === 'education'" class="overflow-auto w-full">
                    <v-card-title class="text-center sticky top-0 z-10 pa-0 pt-5 bg-inherit">
                        <v-icon class="mr-2">mdi-school</v-icon>EDUCATIONAL BACKGROUNDS
                        <v-divider class="mt-5"></v-divider>
                    </v-card-title>

                    <v-container class="d-flex flex-start justify-center flex-wrap ga-10 py-5">
                        <v-card
                            v-for="(item, index) in officialInfos.educationalBackgrounds"
                            :key="index"
                            class="d-flex flex-col justify-start items-center w-[40%] ga-5 rounded-md pa-10"
                            elevation="4"
                        >
                            <v-avatar :image="item.school_logo ? ($store.getters.base + '/schoolLogos/' + item.school_logo) : ($store.getters.base + '/schoolLogos/no-avatar.png')" size="75" />
                            <article class="d-flex flex-col ga-1">
                                <h2 class="text-base uppercase font-bold text-center">{{ item.school_name || 'Unknown School' }}</h2>
                                <p class="text-sm text-center">{{ item.course || 'No Course Specified' }}</p>
                                <h3 class="text-xs font-italic absolute bottom-0 right-0 pa-3">{{ item.start_year || 'N/A' }} - {{ item.end_year || 'N/A' }}</h3>
                            </article>
                        </v-card>
                    </v-container>
                </v-sheet>

                <!-- Personal Achievements Section -->
                <v-sheet v-if="activeTab === 'achievements'" class="overflow-auto w-full">
                    <v-card-title class="text-center sticky top-0 z-10 pa-0 pt-5 mb-10 bg-inherit">
                        <v-icon class="mr-2">mdi-trophy</v-icon>PERSONAL ACHIEVEMENTS
                        <v-divider class="mt-5"></v-divider>
                    </v-card-title>

                    <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 pt-0 ga-10">
                        <v-card elevation="5"
                            v-for="(achievement, index) in officialInfos.achievements"
                            :key="achievement.id"
                            class="card w-[30%] h-[280px] rounded-lg d-flex flex-col items-center overflow-hidden"
                        >
                            <img :src="$store.getters.base + '/achievements/' + achievement.img" alt="" class="elevation-5 w-full rounded-t-lg" />
                            <article class="d-flex flex-col items-start w-[90%] ma-5">
                                <h3 class="uppercase text-xs font-extrabold">{{ achievement.title || 'Untitled Achievement' }}</h3>
                                <h5 class="text-[.75rem] font-medium">{{ achievement.subtitle || 'No Subtitle' }}</h5>
                                <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) || 'No Date' }}</h5>
                            </article>
                        </v-card>
                    </v-container>
                </v-sheet>
            </v-container>

            <!-- Close Button -->
            <v-card-actions class="absolute top-0 right-0 pa-5">
                <v-btn icon color="red" @click="closeDialog">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import $ from 'jquery';
export default {
    name: "DialogComponent",
    computed: {
        isDialogOpen: {
            get() {
                return this.$store.getters['viewOfficial/getViewOfficialOpenDialog'];
            },
            set(value) {
                this.$store.commit('viewOfficial/setViewOfficialOpenDialog', value);
            }
        },
        // Wrap the store getter in a computed property for reactivity.
        officialStore() {
            return this.$store.getters['viewOfficial/getViewOfficial'];
        }
    },
    data() {
        return {
            officialInfos: {
                personalInfo: {},
                educationalBackgrounds: [],
                achievements: []
            },
            activeTab: 'profile', // Default active tab.
            errorMessage: null
        };
    },
    methods: {
        closeDialog() {
            this.isDialogOpen = false;
            this.$store.commit('viewOfficial/setViewOfficialOpenDialog', false);
            this.activeTab = 'profile'
            this.errorMessage = null;
        },
        openDialog(official) {
            this.$store.commit('viewOfficial/setViewOfficial', official);
            this.isDialogOpen = true;
        },
        formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            // Format as "Month Day, Year" (e.g., "March 24, 2025")
            return date.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        },
        async fetchOfficialData(slug) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            await $.ajax({
                url: `${this.$store.getters['api_base']}?e=sk-official&a=personalInfo`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': csrfToken },
                data: { officialSlug: slug },
                success: (data) => {
                    this.officialInfos = data.data;
                    this.errorMessage = null;
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    let errorMsg = "Failed to load official data.";
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMsg = jqXHR.responseJSON.message;
                    }
                    this.errorMessage = errorMsg;
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        }
    },
    created() {
        this.officialInfos = this.$store.getters['viewOfficial/getViewOfficial'] || {
            personalInfo: {},
            educationalBackgrounds: [],
            achievements: []
        };
        if (this.officialInfos?.personalInfo?.slug) {
            this.fetchOfficialData(this.officialInfos.personalInfo.slug);
        }
    },
    watch: {
        officialStore: {
            handler(newVal) {
                if (newVal && newVal.personalInfo && newVal.personalInfo.slug) {
                    this.fetchOfficialData(newVal.personalInfo.slug);
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>

<style scoped>
.active-tab {
    /* Style the active icon button (you can adjust colors, borders, etc.) */
    background-image: linear-gradient(45deg, #004bf9, #f65c66, #ffd45e);
    border-radius: 50%;
}
</style>
