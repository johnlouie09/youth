<template>
    <v-container
      :theme="themeName"
      fluid
      :class="['barangay-main', { 'dark-gradient': isDark }]"
    >
      <div class="dp-barangay elevation-15">
        <img class="logo w-80 h-auto" src="/Logoseal.svg" alt="logo" />
        <div>
          BARANGAY {{ barangay.name.toUpperCase() }}
        </div>
        <img class="logo w-80 h-auto" src="/Logoseal.svg" alt="logo" />
      </div>
      <Announcements></Announcements>
      <Cards></Cards>
      <Achievements :achievements="barangay.achievements" />
    </v-container>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { useTheme } from 'vuetify';
  import Announcements from '@/components/barangayPage/Announcements.vue';
  import Cards from '@/components/barangayPage/Cards.vue';
  import Achievements from '@/components/barangayPage/Achievements.vue';
  import barangayHall from '/San_Francisco_Barangay_Hall.JPG?url';
  
  // Get the current theme using Vuetify's useTheme composable
  const theme = useTheme();
  
  // If you need to bind the theme name to the component, you can do so:
  const themeName = computed(() => theme.global.name.value);
  
  // Check if the current theme is dark. In Vuetify 3 the current theme object contains a boolean "dark" property.
  const isDark = computed(() => theme.current.value.dark);
  
  // Your barangay data
  const barangay = {
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
                        img: '1.jpg',
                        title: "Basketball",
                        subtitle: "Kung walang nilaga sana tayo nalang...",
                        info: "Basketbfall is not just a game—it’s a way to bring communities together, foster teamwork, and inspire young people to achieve their dreams. In our barangay, basketball courts serve as a hub for socializing and learning important life lessons such as discipline, resilience, and the value of hard work."
                    },
                    {
                        img: '2.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    },
                    {
                        img: '3.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    },
                    {
                        img: '4.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    },
                    {
                        img: '5.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    },
                    {
                        img: '6.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    },
                    {
                        img: '7.jpg',
                        title: "Volleyball",
                        subtitle: "Bilog ang bola, bilog din ang mundo...",
                        info: "Volleyball energizes our community by promoting physical fitness and cooperation among neighbors. This sport has been a cornerstone of community events, where participants learn about trust, coordination, and the importance of maintaining a healthy lifestyle, while also having fun and building lasting friendships."
                    }
                ]
  };
  </script>
  
  <style scoped>
  .barangay-main {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10rem;
    margin: 0;
    padding: 0;
    padding-bottom: 5rem;
    background-position: center;
    background-attachment: fixed;
    background-image: linear-gradient(
      45deg,
      rgb(245, 238, 92),
      rgb(255, 255, 255),
      rgba(130, 169, 252, 0.986),
      rgb(255, 255, 255),
      rgb(252, 84, 95)
    );
  }
  
  .dark-gradient {
    background-image: linear-gradient(
      45deg,
      #363636,
      #0e0e0e,
      #363636,
      #0e0e0e
    );
  }
  
  .dp-barangay {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 45vh;
    border-radius: 0 0 2rem 2rem;
    overflow: hidden; /* Ensure pseudo-element doesn't overflow */
  }
  
  /* Pseudo-element with background image */
  .dp-barangay::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url(../../public/San_Francisco_Barangay_Hall.JPG);
    background-position: center;
    background-repeat: repeat;
    background-size: auto;
    opacity: 0.8; /* Adjust opacity as needed */
    z-index: 1;
  }
  
  .dp-barangay div {
    font-size: 3rem;
    font-weight: 900;
    background-image: linear-gradient(
      45deg,
      #0533a0,
      #ffffff,
      #DF2935,
      #d4d4d4,
      #FDCA40,
      #d4d4d4
    );
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  /* Ensure content is on top of the pseudo-element */
  .dp-barangay > * {
    z-index: 2;
  }
  </style>