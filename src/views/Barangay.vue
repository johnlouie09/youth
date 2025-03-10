<template>
    <v-container :theme="$vuetify.theme.global.name.value" fluid class="barangay-main ma-0 pa-0">
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
        <Carousel />
        <Cards></Cards>
        <Achievements :achievements="barangay.achievements" />
    </v-container>
</template>

<script>
import barangayHall from '/San_Francisco_Barangay_Hall.JPG?url';
import Carousel from '@/components/barangayPage/Carousel.vue';
import Cards from '@/components/barangayPage/Cards.vue';
import Achievements from '@/components/barangayPage/Achievements.vue';

export default {
    components: {
        Carousel,
        Cards,
        Achievements
    },
    data() {
        return {
            barangay: {
                name: 'San Francisco',
                img: '/public/San_Francisco_Barangay_Hall.JPG',
                announcements: [{}],
                skOfficials: {
                    skChairperson: {
                        personalInfo: {
                            position: "SK. CHAIRPERSON",
                            motto: "Dawa turog gisngon",
                            name: "Juan Dela Cruz",
                            email: "juandelacruz@example.com",
                            birthday: new Date(2000, 1, 1)
                        },
                        educationalBackground: [
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
                                info: null
                            },
                            {
                                startYear: 2008,
                                endYear: 2014,
                                school: "Ateneo de Naga University Grade School",
                                info: null
                            }
                        ],
                        personalAchievements: [
                            {
                                title: "Certificate of Completion",
                                description: "SK Mandatory Training",
                                date: new Date("July 15, 2023")
                            },
                            {
                                title: "Certificate of Recognition",
                                description: "Successful Organization of the Barangay Youth Sports Festival",
                                date: new Date("November 25, 2023")
                            },
                            {
                                title: "Certificate of Participation",
                                description: "Leadership and Governance Workshop",
                                date: new Date("September 10, 2023")
                            }
                        ],
                        otherInfos: {
                            hobbies: ["Playing Basketball", "Writing Poem"],
                            favoriteShow: "The Crown",
                            favoriteBook: "No Longer Human",
                            inspirationalFigure: "iShowspeed"
                        }
                    },
                    skMembers: [{}, {}, {}]
                },
                achievements: [
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Basketball",
                        subtitle: "Kung walang nilaga sana tayo nalang...",
                        info: "I'm a thing. But, like most politicians, he promised more than he could deliver."
                    },
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "I'm just a ball, but I bring people together."
                    },
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "I'm just a ball, but I bring people together."
                    },
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "I'm just a ball, but I bring people together."
                    },
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "I'm just a ball, but I bring people together."
                    },
                    {
                        img: '/public/Sangguniang_Kabataan_logo.svg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "I'm just a ball, but I bring people together."
                    }
                ]
            },
            barangayHall
        };
    }
};
</script>



<style scoped>
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

.barangay-main {
    display: flex;
    flex-direction: column;
    gap: 10rem;
    background: #000000; /* fallback for old browsers */
    background-image: linear-gradient(45deg, #0e0e0e, #363636); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    /* background-image: linear-gradient(to right top, #18122b, #1e1732, #241d3a, #2a2241, #302849, #342c4e, #382f53, #3c3358, #3e355c, #403760, #423a64, #443c68); */
    background-position: center;
    background-attachment: fixed;

}
</style>