<template>
    <v-dialog v-model="isDialogOpen" max-width="1000px" height="90vh" persistent class="overflow-hidden">
        <v-card style="border-radius: 1rem; font-family: 'Inter', sans-serif;" border="primary lg">
            <div class="grid grid-cols-5 place-items-center pt-15 py-0 px-15 ga-5">

                <!-- Icon Tab Bar with active state -->
                <v-sheet class="col-span-1 d-flex flex-col justify-center gap-5">
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

                        <p class="d-block w-[100%] text-center text-sm text-grey font-italic motto-text py-3">"{{ officialInfos.personalInfo?.motto || 'No Motto Available' }}"</p>

                    </div>
                </div>

                <!-- Button for Advocacies, Platforms and Programs -->
                <v-sheet class="col-span-1 d-flex flex-col justify-center gap-5">
                    <v-btn 
                        class="custom-btn d-flex justify-center text-xl font-bold py-5 px-10 elevation-10"
                        :class="{ 'active-btn': activeTab === 'advocacies' }"
                        @click="activeTab = 'advocacies'"
                    >
                        <span class="overlay-titles">ADVOCACIES</span>
                    </v-btn>

                    <v-btn 
                        class="custom-btn d-flex justify-center text-xl font-bold py-5 px-10 elevation-10"
                        :class="{ 'active-btn': activeTab === 'platforms' }"
                        @click="activeTab = 'platforms'"
                    >
                        <span class="overlay-titles">PLATFORMS</span>
                    </v-btn>

                    <v-btn 
                        class="custom-btn d-flex justify-center text-xl font-bold py-5 px-10 elevation-10"
                        :class="{ 'active-btn': activeTab === 'programs' }"
                        @click="activeTab = 'programs'"
                    >
                        <span class="overlay-titles">PROGRAMS</span>
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

                    <v-container class="w-[90%] d-flex flex-start justify-center flex-wrap ga-10 py-5">
                        <v-timeline class="w-[90%]"       
                        
                        >
                            <v-timeline-item
                            v-for="(item, index) in officialInfos.educationalBackgrounds"
                            :key="index" size="large">
                            
                                <template v-slot:icon>
                                    <v-avatar class="bg-white" :image="item.school_logo ? ($store.getters.base + 'public/schoolLogos/' + item.school_logo) : ($store.getters.base + 'public/schoolLogos/no-avatar.svg')"></v-avatar>
                                </template>

                                <v-card
                                    class="d-flex flex-col justify-start items-center w-full ga-3 rounded-lg border pa-5 pt-10 min-w-[360px]"
                                    elevation="10"
                                >
                                    <v-avatar :image="item.school_logo ? ($store.getters.base + 'public/schoolLogos/' + item.school_logo) : ($store.getters.base + 'public/schoolLogos/no-avatar.svg')" size="75" />
                                    <article class="w-full d-flex flex-col">
                                        <h2 class="w-full text-base uppercase font-bold text-center">{{ item.school_name || 'Unknown School' }}<v-divider class="my-3"></v-divider></h2>
                                        <h3 class="text-sm font-italic font-bold absolute top-0 left-0 pa-5">{{ item.start_year || 'N/A' }} - {{ item.end_year || 'N/A' }}</h3>
                                        <p class="text-sm text-center">{{ item.course || '' }}</p>
                                        
                                    </article>
                                </v-card>
                            </v-timeline-item>
                        </v-timeline>

                        <!-- <v-card
                            v-for="(item, index) in officialInfos.educationalBackgrounds"
                            :key="index"
                            class="d-flex flex-col justify-start items-center w-[40%] ga-5 rounded-md pa-10"
                            elevation="4"
                        >
                            <v-avatar :image="item.school_logo ? ($store.getters.base + 'public/schoolLogos/' + item.school_logo) : ($store.getters.base + 'public/schoolLogos/no-avatar.svg')" size="75" />
                            <article class="d-flex flex-col ga-1">
                                <h2 class="text-base uppercase font-bold text-center">{{ item.school_name || 'Unknown School' }}</h2>
                                <p class="text-sm text-center">{{ item.course || 'No Course Specified' }}</p>
                                <h3 class="text-xs font-italic absolute bottom-0 right-0 pa-3">{{ item.start_year || 'N/A' }} - {{ item.end_year || 'N/A' }}</h3>
                            </article>
                        </v-card> -->
                    </v-container>
                </v-sheet>


                <!-- Personal Achievements Section -->
                <v-sheet v-if="activeTab === 'achievements'" class="overflow-auto w-full">
                    <v-card-title class="d-flex justify-center ga-4 text-center sticky z-10 top-0 bg-inherit border border-gray-200 py-4">
                        <v-icon>mdi-trophy</v-icon>
                        <span class="text-center">PERSONAL ACHIEVEMENTS</span>
                        <v-icon>mdi-trophy</v-icon>
                    </v-card-title>

                    <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 ga-10 rounded-md">
                        <v-card
                        v-for="(achievement, index) in officialInfos.achievements" :key="index"
                        class="card w-[35%] d-flex flex-col items-center ga-2 elevation-10 border pb-5">
                            <img :src="`/achievements/${achievement.img}`" alt="" class="w-full elevation-10">

                            <article class="relative w-[90%] pb-5">
                                <h3 class="text-base uppercase font-extrabold">{{ achievement.title }}</h3>
                                <h5 class="text-sm">{{ achievement.subtitle }}</h5>
                                <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-1">{{ formatDate(achievement.date) }}</h5>
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
                        v-for="n of 3"
                        class="custom-card border rounded-xl elevation-10"
                        :class="{'d-flex flex-col ga-5 items-center w-[90%] elevation-10 px-15 py-10' : showAdvocacyDetails, 'd-flex ga-10 w-[90%] max-h-[250px]' : !showAdvocacyDetails}">

                            <!-- Advocacy Image, Title and Subtitle -->
                            <div :class="{'d-flex justify-evenly items-center ga-5' : showAdvocacyDetails, 'd-flex justify-evenly items-center ga-5 pa-5' : !showAdvocacyDetails}">
                                <v-img 
                                    class="elevation-5 rounded-lg"
                                    :class="{'max-h-[250px] w-[40%]' : showAdvocacyDetails, 'h-full w-[40%]' : !showAdvocacyDetails}"
                                    :src="$store.getters.base + 'Flogo.svg'"    
                                ></v-img>

                                <div class="d-flex flex-col justify-center items-center py-5 ga-2">
                                    <h3 class="w-full text-lg font-extrabold uppercase text-center">
                                        Kabataan, Kabalikat ng Kaunlaran
                                        <v-divider class="mt-3"></v-divider>
                                    </h3>

                                    
                                    <h4 class="w-[80%] text-center font-italic">
                                        Bilang SK Official, tungkulin nating maging tinig at tagapagtanggol ng kabataan. Sama-sama nating itaguyod ang isang barangay na ligtas, progresibo, at makabuluhan para sa lahat.
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
                            <p v-if="showAdvocacyDetails" class="text-justify text-sm">
                                <v-divider class="my-4"></v-divider>
                                Ang Kabataan, Kabalikat ng Kaunlaran ay isang adbokasiyang naglalayong palakasin ang partisipasyon ng kabataan sa mga programang pangkaunlaran ng barangay. Bilang mga SK Official, isinusulong namin ang aktibong pakikilahok ng kabataan sa paggawa ng mga proyekto ukol sa edukasyon, kalusugan, kabuhayan, at kalikasan. Layunin naming bigyan ng boses ang kabataan sa bawat desisyon at plano ng barangay, upang masiguro na ang kanilang mga pangangailangan at adhikain ay naisasama sa paghubog ng mas maunlad na komunidad. Sa pamamagitan ng mga pagsasanay, seminar, clean-up drives, youth assemblies, at livelihood programs, nais naming mailapit ang gobyerno sa kabataan at maisulong ang kabataang may malasakit, disiplina, at ambag sa bayan.
                            </p>

                            <!-- Platforms Under this Advocacy -->
                            <div v-if="showAdvocacyDetails" class="w-full d-flex flex-col justify-center items-center text-lg ga-5 elevation-10 pa-5 py-10">
                                <h3 class="text-center teact-xl font-extrabold ">PLATFORMS FOR THIS ADVOCACY</h3>

                                <v-sheet class="w-full d-flex flex-row justify-center items-center flex-wrap ga-5">
                                    <v-card v-for="n of 2" class="w-auto d-flex flex-col flex-wrap justify-center items-center px-10 py-5 ga-2 elevation-5">
                                        <h4 class="uppercase text-sm text-center font-semibold">Kabataang Handa sa Kinabukasan lorem</h4>
                                        <v-card-actions>
                                            <v-btn class="w-full" color="teal">
                                                GO TO PLATFORM 
                                                <v-icon class="ml-2">mdi-launch</v-icon>
                                            </v-btn>                                            
                                        </v-card-actions>

                                    </v-card>
                                </v-sheet>


                            </div>
                            
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
                        v-for="n of 2"
                        class="custom-card d-flex flex-col justify-center items-center ga-5 py-10 pb-3 w-[90%] border rounded-xl elevation-10">

                            <div class="w-[90%] d-flex flex-col justify-center items-center ga-3">
                                <div class="d-flex flex-col justify-center items-center">
                                    <h3 class="w-full text-2xl font-extrabold uppercase text-center" >
                                        Kabataang Handa sa Kinabukasan  
                                    </h3>
                                    
                                    <h4 class="w-full text-center text-xs font-bold italic capitalize text-grey">Advocacy: Kabataan, Kabalikat ng Kaunlaran</h4>
                                </div>
                                


                                <p class="w-full text-justify text-sm font-italic">
                                    Ang platformang ito ay nakatuon sa pagbibigay ng kaalaman, kasanayan, at oportunidad sa kabataan upang sila ay maging handa sa kanilang hinaharap. Sa pamamagitan ng mga programang nakatuon sa edukasyon at kabuhayan, layunin nitong palakasin ang kakayahan ng kabataan na maging produktibo at may direksyon sa buhay. Nais nating matulungan ang kabataan na maabot ang kanilang mga pangarap sa pamamagitan ng konkretong suporta tulad ng skills training.
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
                        v-for="n of 5"
                        class="custom-card w-[90%] d-flex justify-center items-center border rounded-xl elevation-10"
                        :class="{'flex-col py-10 ga-5' : showProgramDetails, 'ga-5 max-h-[300px] px-7 py-5' : !showProgramDetails}">

                            <div
                            class="d-flex justify-center items-center"
                            :class="{'w-[80%] flex-row ga-10': showProgramDetails, 'flex-col w-[40%] ' : !showProgramDetails}">

                                <div>
                                    <img 
                                    class=" elevation-5 rounded"
                                    :src="$store.getters.base + 'ex.jpg'"                    
                                    ></img>
                                </div>

                                <v-card-actions 
                                class="d-flex"
                                :class="{'justify-start items-start flex-col ga-5': showProgramDetails, 'justify-center items-center' : !showProgramDetails}">
                                
                                    <!-- <v-chip color="green">DONE<v-icon class="ml-1">mdi-check</v-icon></v-chip> -->

                                    <!-- <v-chip color="yellow">PENDING<v-icon class="ml-1">mdi-reload</v-icon></v-chip> -->

                                    <v-chip color="red">DISMISSED<v-icon class="ml-1">mdi-close-circle-outline</v-icon></v-chip>

                                    <v-btn color="teal">GO TO ACHIEVEMENT
                                        <v-icon>mdi-launch</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </div>

                         


                            <div 
                            class="d-flex flex-col justify-evenly items-center ga-1"
                            :class="{'pt-5' : showProgramDetails, 'py-5 pr-5' : !showProgramDetails}">
                                <h3 
                                class="font-extrabold text-center uppercase"
                                :class="{'text-xl w-[90%]' : showProgramDetails, 'w-full' : !showProgramDetails}"
                                >
                                    Kabataan Hub: Skills and Livelihood Training
                                </h3>

                                
                                <p 
                                class="text-center italic text-sm"
                                :class="{'w-[90%]' : showProgramDetails, 'w-full' : !showProgramDetails}">
                                    Magkakaloob ng libreng workshops at hands-on training sa mga kabataan tulad ng computer literacy, basic entrepreneurship, online freelancing, baking, at iba pang praktikal na kaalaman. Layon nitong bigyan sila ng kakayahang kumita o makapagsimula ng sariling negosyo, kahit habang nag-aaral.
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
                            class="w-[90%] text-justify"><v-divider class="pb-3"></v-divider> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt quia pariatur odio quaerat reprehenderit molestiae exercitationem cupiditate dignissimos dolor, et, placeat enim magnam suscipit corporis, accusamus numquam eaque saepe repellendus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, culpa aperiam et inventore, beatae dolorum recusandae totam eaque fuga suscipit ratione. Odio, quod? Labore officia cupiditate omnis vitae neque corrupti?</p>

                            
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

<script>
import SocialLinks from '../landingPageComponents/SocialLinks.vue';
import $ from 'jquery';
export default {
    name: "DialogComponent",
    components : {
        SocialLinks
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
            showProgramDetails: false
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

.card {
    transition: transform 0.3s ease-in-out, border 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.04);
}

</style>
