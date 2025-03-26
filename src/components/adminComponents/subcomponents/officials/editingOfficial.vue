<template>
    <v-container class="editing-official-main">
        <PersonalInfoCard :info="officialInfos.personalInfo"></PersonalInfoCard>
        <EducationalOfficial :educations="officialInfos.educationalBackgrounds"></EducationalOfficial>
        <PersonalAchievements :achievements="officialInfos.achievements" @fetchOfficialInfo="fetchSkOfficialInfos"></PersonalAchievements>
        <!-- <OtherInformation></OtherInformation> -->
        <div class="back" @click="$router.replace({name: 'admin-officials', params:{barangaySlug : this.$store.getters[auth/getBarangayName]}})">
            <v-icon>mdi-arrow-left</v-icon>
        </div>




    </v-container>
</template>

<script>
import PersonalInfoCard from "./PersonalInfoCard.vue";
import EducationalOfficial from "./EducationalOfficial.vue";
import PersonalAchievements from "./PersonalAchievements.vue";
import OtherInformation from "./OtherInformation.vue";

import $ from 'jquery';

export default {
    components: {
        PersonalInfoCard,
        EducationalOfficial,
        PersonalAchievements,
        OtherInformation
    },
    data() {
        return {
            skOfficialSlug: this.$route.params.officialSlug,
            officialInfos: {
                personalInfo: {},
                educationalBackgrounds: [],
                achievements: []
            },
            
        }
    },
    methods: {
        fetchSkOfficialInfos() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const api_base = 'http://localhost/youth/app/api.php';
            $.ajax({
                url: `${api_base}?e=sk-official&a=personalInfo`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': csrfToken },
                data: { officialSlug: this.skOfficialSlug},
                success: (data) => {
                    this.officialInfos = data.data;
                    console.log(data);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        }
    },
    created() {
        this.fetchSkOfficialInfos();
    },
    watch: {
    '$route.params': {
      handler(newParams) {
        this.skOfficialSlug = newParams.officialSlug;
      },
      deep: true
    }
  }

};
</script>

<style scoped>
.editing-official-main {
    padding: 4rem 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4rem;
}

.back {
    position: absolute;
    top: 4rem;
    right: 4rem;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    padding: 1.5rem;
}




</style>
