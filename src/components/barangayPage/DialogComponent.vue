<script>
import SocialLinks from '../landingPageComponents/SocialLinks.vue';
import Achievements from './Achievements.vue';
import $ from 'jquery';
export default {
    name: "DialogComponent",
    components : {
        SocialLinks,
        Achievements
    },
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
            errorMessage: null,

            showAdvocacyDetails: false,
            showPlatformDetails: false,
            showProgramDetails: false,
            
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
                    console.log(data.data);
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
        },

        // HELPER METHODS
        getTitleAdvocacy(advocacyId) {
            const advocacy = this.officialInfos.advocacies.find(a => a.id === advocacyId);
            return advocacy ? advocacy.title : 'Unknown Advocacy';
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

<template>
    <v-dialog v-model="isDialogOpen" max-width="1000px" height="90vh" persistent class="overflow-hidden">
        <v-card style="border-radius: 1rem; font-family: 'Inter', sans-serif;" border="primary lg">
            <div class="grid grid-cols-5 place-items-center pt-13 py-0 px-15 ga-5">

                <!-- Icon Tab Bar with active state -->
                <v-sheet class="h-full col-span-1 d-flex flex-col justify-evenly">
                    <v-btn
                        icon
                        class="elevation-10"
                        :class="{ 'active-tab': activeTab === 'profile' }"
                        @click="activeTab = 'profile'">
                        <v-icon>mdi-account</v-icon>
                    </v-btn>
                    <v-btn
                        icon
                        class="elevation-10"
                        :class="{ 'active-tab': activeTab === 'education' }"
                        @click="activeTab = 'education'">
                        <v-icon>mdi-school</v-icon>
                    </v-btn>
                    <v-btn
                        icon
                        class="elevation-10"
                        :class="{ 'active-tab': activeTab === 'achievements' }"
                        @click="activeTab = 'achievements'">
                        <v-icon>mdi-trophy</v-icon>
                    </v-btn>
                </v-sheet>

                <div class="col-span-3 d-flex flex-col align-center justify-center ga-5">
                    <v-avatar
                        :image="officialInfos.personalInfo.img? ($store.getters.base + 'public/OfficialImages/' + officialInfos.personalInfo?.img) : '/public/OfficialImages/no-avatar.png'"
                        size="150"
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

                        <p class="d-block w-[100%] text-center text-sm text-grey font-italic motto-text py-3">"{{ officialInfos.personalInfo?.motto || 'No Motto Available' }}"</p>

                    </div>
                </div>

                <!-- Button for Advocacies, Platforms and Programs -->
                <v-sheet class="h-full col-span-1 d-flex flex-col justify-evenly">
                    <v-btn 
                        class="custom-btn d-flex justify-center font-bold px-8 py-4 elevation-10"
                        :class="{ 'active-btn': activeTab === 'advocacies' }"
                        @click="activeTab = 'advocacies';"
                    >
                        <span class="overlay-titles text-xs">ADVOCACIES</span>
                    </v-btn>

                    <v-btn 
                        class="custom-btn d-flex justify-center font-bold px-8 py-4 elevation-10"
                        :class="{ 'active-btn': activeTab === 'platforms' }"
                        @click="activeTab = 'platforms'"
                    >
                        <span class="overlay-titles text-xs">PLATFORMS</span>
                    </v-btn>

                    <v-btn 
                        class="custom-btn d-flex justify-center text-xl font-bold px-8 py-4 elevation-10"
                        :class="{ 'active-btn': activeTab === 'programs' }"
                        @click="activeTab = 'programs'"
                    >
                        <span class="overlay-titles text-xs">PROGRAMS</span>
                    </v-btn>
                </v-sheet>

            </div>

            <v-divider class="mt-5"></v-divider>

            <!-- Error Alert if fetch fails -->
            <v-alert v-if="errorMessage" type="error" class="mx-5">{{ errorMessage }}</v-alert>

            <!-- Content Sections -->
            <v-container style="position: relative; overflow-y: auto; display: flex; justify-content: center; height: 100%; padding: 0;">

                <!-- Profile Information Section -->
                <v-sheet v-if="activeTab === 'profile'" class="w-full rounded-lg">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <v-icon>mdi-account</v-icon>
                        <span class="text-center">PROFILE INFORMATION</span>
                        <v-icon>mdi-account</v-icon>
                    </v-card-title>

                    <v-container class="d-flex flex-col justify-start items-center gap-5">
                        <!-- Email and Mobile Number -->
                        <v-sheet class="d-flex w-[90%] gap-5">
                            <v-card class="d-flex flex-row justify-start items-center ga-5 w-full pa-5 elevation-3">
                                <v-icon>mdi-email</v-icon>
                                <div>
                                    <p>{{ officialInfos.personalInfo?.email || 'N/A' }}</p>
                                    <h5 class="text-xs font-bold">Email</h5>
                                </div>
                            </v-card>
                            <v-card class="d-flex flex-row justify-start items-center ga-5 w-full pa-5 elevation-3">
                                <v-icon>mdi-phone</v-icon>
                                <div>
                                    <p>{{ officialInfos.personalInfo?.contact_number || 'N/A' }}</p>
                                    <h5 class="text-xs font-bold">Mobile</h5>
                                </div>
                            </v-card>
                        </v-sheet>

                        <!-- Birthdate and Address -->
                        <v-sheet class="d-flex ga-5 w-[90%]">
                            <v-card class="d-flex flex-row justify-start items-center ga-5 w-full px-5 py-5 elevation-3">
                                <v-icon>mdi-cake-variant</v-icon>
                                <div>
                                    <p class="text-base">{{ formatDate(officialInfos.personalInfo?.birthday) || 'N/A' }}</p>
                                    <h5 class="text-xs font-bold">Birthdate</h5>
                                </div>
                            </v-card>     
                            
                            <v-card class="d-flex flex-row justify-start items-center ga-5 w-full px-5 py-5 elevation-3">
                                <v-icon>mdi-map-marker</v-icon>
                                <div>
                                    <p class="text-base">Hyehwa-dong, Jongno-gu, Seoul</p>
                                    <h5 class="text-xs font-bold">Address</h5>
                                </div>
                            </v-card>      
                        </v-sheet>

                        <!-- Term Start and Term End -->
                        <v-sheet class="d-flex w-[90%] justify-center items-center flex-wrap flex-col">
                            <v-divider class="w-full my-3"></v-divider>
                            
                            <div class="d-flex w-full justify-evenly items-center">
                                <v-card class="d-flex items-center px-10 py-3 ga-5 elevation-3">
                                    <v-icon>mdi-calendar-start</v-icon>
                                    <v-card-item>
                                        <span class="text-base">{{ formatDate(officialInfos.personalInfo?.term_start) || 'N/A' }}</span>
                                        <h5 class="text-xs font-bold">TERM START</h5>
                                    </v-card-item>

                                </v-card>
                                <v-card  class="d-flex items-center px-10 py-3 pa-2 ga-5 elevation-3">
                                    <v-icon>mdi-calendar-end</v-icon>
                                    <v-card-item>
                                        <span class="text-base">{{ formatDate(officialInfos.personalInfo?.term_end) || 'N/A' }}</span>
                                        <h5 class="text-xs font-bold">TERM END</h5>
                                    </v-card-item>
                                </v-card>
                            </div>
                        </v-sheet>
     
                        <!-- Social Media Accounts -->
                        <div class="w-[90%] d-flex flex-col justify-center items-center py-5 px-10 ga-3 elevation-3">
                            <div class="text-sm w-full text-center font-bold text-grey italic uppercase">
                                SOCIAL MEDIA ACCOUNTS
                                <v-divider class="my-3"></v-divider>
                            </div>  

                            <div class="d-flex flex-row justify-evenly items-center w-full">
                                <v-btn icon href="https://www.facebook.com/profile.php?id=100078971831746" target="_blank" rel="noopener noreferrer" size="30">
                                    <v-avatar size="30" :image="$store.getters.base + 'public/fb.png'"></v-avatar>      
                                </v-btn>
                        
                                <v-btn icon size="30">
                                    <v-avatar size="30" class="w-full h-full" :image="$store.getters.base + 'public/insta.png'"></v-avatar>
                                </v-btn>

                                <v-btn icon size="30">
                                    <v-avatar size="30" class="w-full h-full" :image="$store.getters.base + 'public/yt.png'" ></v-avatar>
                                </v-btn>

                                <v-btn icon size="30">
                                    <v-icon size="30">mdi-link-variant</v-icon>
                                </v-btn>

                            </div>
                        </div>
                    </v-container>
                </v-sheet>


                <!-- Educational Backgrounds Section -->
                <v-sheet v-if="activeTab === 'education'" class="overflow-auto w-full">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <v-icon>mdi-school</v-icon>
                        <span class="text-center">EDUCATIONAL BACKGROUNDS</span>
                        <v-icon>mdi-school</v-icon>
                    </v-card-title>

                    <v-container class="w-[90%] d-flex flex-start justify-center items-center flex-wrap ga-5 py-5">
                        <v-timeline class="w-[90%]">
                            <v-timeline-item
                            v-for="(item, index) in officialInfos.educationalBackgrounds"
                            :key="index" size="large">
                            
                                <template v-slot:icon>
                                    <v-avatar class="bg-white" :image="item.institution_logo ? ($store.getters.base + 'public/schoolLogos/' + item.institution_logo) : ($store.getters.base + 'public/schoolLogos/no-avatar.svg')"></v-avatar>
                                </template>

                                <v-card
                                    class="d-flex flex-col justify-start items-center w-full ga-3 rounded-lg border pa-5 pt-10 min-w-[360px]"
                                    elevation="10"
                                >
                                    <v-avatar :image="item.institution_logo ? ($store.getters.base + 'public/schoolLogos/' + item.institution_logo) : ($store.getters.base + 'public/schoolLogos/no-avatar.svg')" size="75" />
                                    <article class="w-full d-flex flex-col border-b py-3">
                                        <h2 class="w-full text-base uppercase font-bold text-center">{{ item.institution || 'Unknown Institution' }}</h2>
                                        <h3 class="text-sm font-italic font-bold absolute top-0 left-0 pa-5">{{ item.start_year || 'N/A' }} - {{ item.end_year || 'N/A' }}</h3>
                                        <p class="text-sm text-center">{{ item.course_or_details|| '' }}</p>  
                                    </article>

                                    <div v-if="item.educational_achievements" class="w-full d-flex flex-col ga-2">
                                        <h3 class="w-full text-center text-sm font-bold">EDUCATIONAL ACHIEVEMENTS</h3>
                                        <p class="w-full text-xs text-center ">{{ item.educational_achievements }}</p>
                                    </div>
                                </v-card>
                            </v-timeline-item>
                        </v-timeline>
                    </v-container>
                </v-sheet>


                <!-- Personal Achievements Section -->
                <v-sheet v-if="activeTab === 'achievements'" class="overflow-auto w-full">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <v-icon>mdi-trophy</v-icon>
                        <span class="text-center">PERSONAL ACHIEVEMENTS</span>
                        <v-icon>mdi-trophy</v-icon>
                    </v-card-title>

                    <v-container class="grid grid-cols-3 justify-evenly px-15 ga-10 rounded-md">
                        <v-card
                            v-for="(achievement, index) in officialInfos.achievements" :key="index"
                            class="card w-full custom-card elevation-10 col-span-1"
                        >
                            <img :src="achievement.img ? ($store.getters.base + 'public/achievements/' + achievement.img) : ($store.getters.base + 'public/achievements/no-avatar.png')" 
                            class="w-full max-h-[60%] elevation-10"
                            cover>

                            <article class="relative">
                                <h3 class="text-sm uppercase font-extrabold">{{ achievement.title }}</h3>
                                <h5 class="text-sm">{{ achievement.subtitle }}</h5>
                            </article>


                        </v-card>
                    </v-container>  
                </v-sheet>


                <!-- Advocacies Section -->
                <v-sheet v-if="activeTab === 'advocacies'" class="overflow-auto w-full">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <span class="text-center">ADVOCACIES</span>
                    </v-card-title>

                    <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 ga-10">
                        <v-card
                        v-for="(advocacy, index) in officialInfos.advocacies"
                        class="custom-card border rounded-lg elevation-10"
                        :class="{'d-flex flex-col ga-5 items-center w-[90%] elevation-10 px-10 pt-10 pb-5' : showAdvocacyDetails, 'd-flex ga-10 w-[90%] max-h-[250px]' : !showAdvocacyDetails}">

                            <!-- Advocacy Image, Title and Subtitle -->
                            <div :class="{'w-full d-flex justify-evenly items-center ga-5' : showAdvocacyDetails, 'w-full d-flex justify-evenly items-center ga-5 pa-5' : !showAdvocacyDetails}">
                                <v-img 
                                    class="elevation-5 rounded-lg"
                                    :class="{'w-[35%]' : showAdvocacyDetails, 'w-[40%]' : !showAdvocacyDetails}"
                                    :src="
                                        advocacy?.thumbnail 
                                        ? ($store.getters.base + 'public/advocacyImages/' + advocacy.thumbnail) 
                                        : ($store.getters.base + 'public/advocacyImages/no-avatar.png')"
                                    cover  
                                ></v-img>


                                <div class="w-full d-flex flex-col justify-evenly items-center">
                                    <h3 class="w-full text-lg font-extrabold uppercase text-center">
                                        {{ advocacy.title || 'No Title Available' }}
                                        <v-divider class="mt-3"></v-divider>
                                    </h3>

                                    
                                    <h4 class="w-[90%] text-center font-italic">
                                        {{ advocacy.subtitle || 'No Subtitle Available' }}
                                    </h4>

                                    <v-card-actions v-if="!showAdvocacyDetails" >
                                        <v-btn 
                                        class="px-5"
                                        color="teal"
                                        @click="showAdvocacyDetails = !showAdvocacyDetails"
                                        >
                                            {{ showAdvocacyDetails ? "LESS DETAILS" : "MORE DETAILS" }}
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>

                            <!-- Advocacy Details -->
                            <p v-if="showAdvocacyDetails" class="w-full text-center border-t pt-3">
                                {{ advocacy.detail || 'No Details Available' }}
                            </p>
                            
                            <v-card-actions v-if="showAdvocacyDetails" >
                                <v-btn 
                                class="px-5"
                                color="teal"
                                @click="showAdvocacyDetails = !showAdvocacyDetails"
                                >
                                    {{ showAdvocacyDetails ? "LESS DETAILS" : "MORE DETAILS" }}
                                </v-btn>
                            </v-card-actions>

                        </v-card>
                    </v-container>
                </v-sheet>

                <!-- Platforms Section -->
                <v-sheet v-if="activeTab === 'platforms'" class="overflow-auto w-full rounded-xl">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <span class="text-center">PLATFORMS</span>
                    </v-card-title>

                    <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 ga-10">
                        <v-card
                        v-for="(platform, index) in officialInfos.platforms"
                        class="custom-card d-flex flex-col justify-center items-center ga-5 py-10 pb-3 w-[90%] border rounded-lg elevation-10">

                            <div class="w-[90%] d-flex flex-col justify-center items-center ga-3">
                                <div class="d-flex flex-col justify-center items-center">
                                    <h3 class="w-full text-2xl font-extrabold uppercase text-center" >
                                        {{ platform.title || 'No Title Available' }} 
                                    </h3>
                                    
                                    <h4 class="w-full text-center text-xs font-bold italic capitalize text-grey">Advocacy: {{ getTitleAdvocacy(platform.sk_advocacy_id) }}</h4>
                                </div>
                                


                                <p class="w-full text-justify text-sm font-italic">
                                    {{ platform.detail || 'No Details Available' }}
                                </p>
                            </div>

                            

                            <div v-if="showPlatformDetails" class="w-[90%] d-flex flex-col flex-wrap justify-center py-5 ga-2 items-center elevation-10 rounded-lg">
                                <h3 class="uppercase font-extrabold">Proposed Programs under this Platforms</h3>

                                <div class="w-full d-flex flex-wrap justify-evenly items-center ga-5">
                                    <div v-for="n of 3" class="w-auto d-flex justify-evenly items-center py-5 px-5 ga-5 rounded-md elevation-5">
                                        
                                        <h4 class="text-center">Kabataan Hub: Skills and Livelihood Training </h4>
                                        
                                        <v-card-actions>
                                        <!-- <v-chip color="green">DONE<v-icon class="ml-1">mdi-check</v-icon></v-chip> -->

                                        <!-- <v-chip color="yellow">PENDING<v-icon class="ml-1">mdi-reload</v-icon></v-chip> -->

                                        <v-chip color="red">DISMISSED<v-icon class="ml-1">mdi-close-circle-outline</v-icon></v-chip>
                                        
                                            <v-btn width="auto" class="ma-auto" color="teal">
                                                GO TO PROGRAM 
                                                <v-icon class="ml-2">mdi-launch</v-icon>
                                            </v-btn>
                                        </v-card-actions>
                                    </div>
                                </div>

                            </div>

                            <v-card-actions class="w-[90%] d-flex flex-col justify-start items-center">
                                <v-btn 
                                @click="showPlatformDetails = !showPlatformDetails"
                                color="teal">
                                    {{ showPlatformDetails ? "HIDE PROGRAMS" : "SHOW PROGRAMS" }}                  
                                </v-btn>
                            </v-card-actions>

                        </v-card>
                        
                    </v-container>
                </v-sheet>

                <!-- Programs Section -->
                <v-sheet v-if="activeTab === 'programs'" class="overflow-auto w-full">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <span class="text-center">PROGRAMS</span>
                    </v-card-title>

                    <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 ga-10">
                        <v-card
                        v-for="(program, index) in officialInfos.programs"
                        class="custom-card w-[90%] d-flex justify-center items-center border rounded-lg elevation-10"
                        :class="{'flex-col py-10' : showProgramDetails, 'ga-5 max-h-[300px] px-7 py-5' : !showProgramDetails}">

                            <div
                            class="d-flex justify-center items-center"
                            :class="{'w-[80%] flex-col': showProgramDetails, 'flex-col w-[40%]' : !showProgramDetails}">

                                <div :class="{'w-[35%]' : showProgramDetails, 'w-full' : !showProgramDetails}">
                                    <v-img 
                                    class=" elevation-5 rounded"
                                    :src="program.thumbnail ? ($store.getters.base + 'public/programImages/' + program.thumbnail) : ($store.getters.base + 'public/programImages/no-avatar.png')"    
                                    cover                 
                                    ></v-img>
                                </div>

                                <v-card-actions 
                                class="d-flex"
                                :class="{'justify-start items-start flex-row ga-5': showProgramDetails, 'justify-center items-center' : !showProgramDetails}">
                                
                                    <!-- <v-chip color="green">DONE<v-icon class="ml-1">mdi-check</v-icon></v-chip> -->

                                    <!-- <v-chip color="yellow">PENDING<v-icon class="ml-1">mdi-reload</v-icon></v-chip> -->

                                    <v-chip class="w-full d-flex flex-col justify-center items-center" color="red">
                                        <span>DISMISSED</span>
                                        <v-icon class="ml-2">mdi-close-circle-outline</v-icon>
                                    </v-chip>

                                    <v-btn color="teal text-xs" icon>
                                        <v-icon>mdi-launch</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </div>


                            <div 
                            class="d-flex flex-col justify-evenly items-center w-full h-full"
                            :class="{'justify-start ga-1' : showProgramDetails, '' : !showProgramDetails}">
                                <h3 
                                class="font-extrabold text-center uppercase"
                                :class="{'text-xl w-[90%]' : showProgramDetails, 'w-full border-b py-3' : !showProgramDetails}"
                                >
                                    {{ program.title || 'No Title Available' }}
                                </h3>

                                
                                <p 
                                class="w-[90%] text-center italic text-sm"
                                >
                                    {{ program.subtitle || 'No Subtitle Available' }}  
                                </p>


                                <v-card-actions
                                v-if="!showProgramDetails">
                                    <v-btn 
                                    class="px-5"
                                    color="teal"
                                    @click="showProgramDetails = !showProgramDetails"
                                    >
                                        MORE DETAILS
                                    </v-btn>
                                </v-card-actions>
                            </div>

                            <p 
                            v-if="showProgramDetails"
                            class="w-[90%] text-justify mt-2 py-3 border-t">{{program.detail || 'No Details Available' }}</p>

                            
                            <v-card-actions
                            v-if="showProgramDetails">
                                <v-btn 
                                class="px-5"
                                color="teal"
                                @click="showProgramDetails = !showProgramDetails"
                                >
                                    HIDE DETAILS
                                </v-btn>
                            </v-card-actions>
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


<style scoped>
.active-tab {
    /* Style the active icon button (you can adjust colors, borders, etc.) */
    background-image: linear-gradient(45deg, #004bf9, #f65c66, #ffd45e);
    border-radius: 50%;
}

.card {
    border-radius: .5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    position: relative;
    transition: transform 0.3s ease-in-out, border 0.3s ease-in-out;

}

.card:hover {
    transform: scale(1.04);
}

</style>
