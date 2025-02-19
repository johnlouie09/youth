<script setup>
import Preloader from "../../components/Preloader.vue";
import barangayHall from '/San_Francisco_Barangay_Hall.JPG?url';
import Carousel from "../../components/Carousel.vue";
import Cards from "../../components/Cards.vue";
import Achievements from "../../components/Achievements.vue";
import ThemeSwitcher from "../../components/ThemeSwitcher.vue";
import { reactive } from "vue";


const barangay = reactive({
    name : 'San Francisco',
    img : '/public/San_Francisco_Barangay_Hall.JPG',
    announcements : [
        {}
    ],
    skOfficials : {
        skChairperson : {
            personalInfo : {
                position : "SK. CHAIRPERSON",
                motto : "Dawa turog gisngon",
                name : "Juan Dela Cruz",
                email : "juandelacruz@example.com",
                birthday: new Date(2000, 1, 1)
            },
            educationalBackground : [
                {
                    startYear: 2020,
                    endYear: 2024,
                    school: "Ateneo de Naga University",
                    info: "Bachelor of Public Administration (BPA)"
                },
                {
                    startYear: 2018,
                    endYear: 2020,
                    school: "Ateneo de Naga University Senior High School",
                    info: "Strand: STEM (Science, Technology, Engineering, and Mathematics)"
                },
                {
                    startYear: 2014,
                    endYear: 2018,
                    school: "Naga City Science High School",
                    info: null // No specific info given
                },
                {
                    startYear: 2008,
                    endYear: 2014,
                    school: "Ateneo de Naga University Grade School",
                    info: null // No specific info given
                }
            ],
            personalAchievements : [
                {
                    title: "Certificate of Completion",
                    description: "SK Mandatory Training",
                    date: new Date("July 15, 2023") // Convert string to Date object
                },
                {
                    title: "Certificate of Recognition",
                    description: "Successful Organization of the Barangay Youth Sports Festival",
                    date: new Date("November 25, 2023") // Convert string to Date object
                },
                {
                    title: "Certificate of Participation",
                    description: "Leadership and Governance Workshop",
                    date: new Date("September 10, 2023") // Convert string to Date object
                }
            ],
            otherInfos : {
                hobbies: [
                    "Playing Basketball",
                    "Writing Poem"
                ],
                favoriteShow: "The Crown",
                favoriteBook: "No Longer Human",
                inspirationalFigure: "iShowspeed"
            }
        },
        skMembers : [
            {},
            {},
            {}
        ]

    },
    achievements: [
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "Basketball",
        subtitle: "Kung walang nilaga sana tayo nalang...",
        info: "I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape."
    },
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "Volleyball",
        subtitle: "Bilog ang bola, bilog din ang mundo...",
        info: "I'm just a ball, but I bring people together. Whether it's a spike or a dig, teamwork makes the dream work. Now, if only life had a referee like our games..."
    },
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "Chess",
        subtitle: "Minsan pawns lang tayo sa buhay...",
        info: "It's all about strategy and patience. A single move can change everything. The real question is, are you thinking three steps ahead, or just reacting to life?"
    },
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "E-Sports",
        subtitle: "GG EZ or GG WP? Ikaw bahala...",
        info: "The digital battlefield is ruthless, but so is life. Adapt, improve, and respawn stronger. Just remember, lag is not an excuse—it's a challenge."
    },
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "Badminton",
        subtitle: "Ang smash ko parang feelings mo—di mo maibalik...",
        info: "A game of speed, reflexes, and precision. One flick of the wrist can change the rally. Just like in life, the best way to win is to stay light on your feet and strike at the right moment."
    },
    {
        img: '/public/Sangguniang_Kabataan_logo.svg',
        title: "Marathon",
        subtitle: "Takbo lang, parang may forever...",
        info: "Endurance is the name of the game. It’s not about who’s the fastest, but who keeps going. Just like life, every step forward is a win, no matter the pace."
    }
    ]

})

</script>

<template>
    <Preloader/>
    <v-app :theme="$vuetify.theme.global.name.value">
        <v-app-bar app color="black">
            <v-img src="/youth.svg" style="scale: 300%; margin-left: -300px;"></v-img>
            <v-spacer></v-spacer>
            <v-btn>
                <ThemeSwitcher />
            </v-btn>
        </v-app-bar>

        <div class="relative flex justify-center items-center overflow-hidden">
            <img class="w-full object-fill" :src="barangayHall" alt="" style="height: 350px;" />

            <div class="absolute left-0 top-1/2 transform -translate-y-1/2" style="margin-left: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>

            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-5xl font-bold">
                {{ `Barangay ${barangay.name}` }}
            </div>
            <div class="absolute right-0 top-1/2 transform -translate-y-1/2" style="margin-right: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>
        </div>

        <br>

        <div>
            <h1 class="gradient-text">Announcements</h1>
            <Carousel/>
            <br>
            <Cards/>
        </div>

       <br>

        <h1 class="gradient-text">Achievements</h1>
        <Achievements :achievements="barangay.achievements"/>
    </v-app>
</template>

<style>

.gradient-text {
    background-image: linear-gradient(to right, #3772FF 40%, #DF2935 50%, #FDCA40 60%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: bold;

}

</style>
