<script>
    import PersonalInfoCard from "./PersonalInfoCard.vue";
    import EducationalOfficial from "./EducationalOfficial.vue";
    import PersonalAchievements from "./PersonalAchievements.vue";
    import AdvocacyForm from "./AdvocacyForm.vue";
    import PlatformForm from "./PlatformForm.vue";
    import ProgramForm from "./ProgramForm.vue";
    import Dialogs from "@/components/dialogs/Dialogs.vue";

    import $ from 'jquery';

    export default {
        components: {
            PersonalInfoCard,
            EducationalOfficial,
            PersonalAchievements,
            AdvocacyForm,
            PlatformForm,
            ProgramForm,
            Dialogs
        },
        emits: ['fetchOfficialInfo'],
        data() {
            return {
                skOfficialSlug: this.$route.params.officialSlug,
                officialInfos: {
                    personalInfo           : {},
                    educationalBackgrounds : [],
                    achievements           : [],
                }     
            }
        },
        methods: {
            fetchSkOfficialInfos() {
                $.ajax({
                    url: `${this.$store.getters.api_base}?e=sk-official&a=personalInfo`,
                    type: 'POST',
                    xhrFields: { withCredentials: true },
                    headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                    data: { officialSlug: this.skOfficialSlug},
                    success: (data) => {
                        this.officialInfos = data.data;
                        console.log(data.data.educationalBackgrounds);
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

<template>
    <v-container class="editing-official-main">
        <PersonalInfoCard :info="officialInfos.personalInfo" :id="officialInfos.personalInfo.id" @fetchOfficialInfo="fetchSkOfficialInfos"></PersonalInfoCard>
        <EducationalOfficial :educations="officialInfos.educationalBackgrounds" :id="officialInfos.personalInfo.id" @fetchOfficialInfo="fetchSkOfficialInfos"></EducationalOfficial>
        <PersonalAchievements :achievements="officialInfos.achievements" :id="officialInfos.personalInfo.id" @fetchOfficialInfo="fetchSkOfficialInfos"></PersonalAchievements>
        <AdvocacyForm :advocacies="officialInfos.advocacies" :id="officialInfos.personalInfo.id" @fetchOfficialInfo="fetchSkOfficialInfos"></AdvocacyForm>
        <PlatformForm :advocacies="officialInfos.advocacies" :platforms="officialInfos.platforms" @fetchOfficialInfo="fetchSkOfficialInfos"></PlatformForm>
        <ProgramForm></ProgramForm>
        <Dialogs />
        <!-- Button to Official Page in Admin -->
        <div class="back" @click="$router.replace({name: 'admin-officials', params:{barangaySlug : this.$store.getters[auth/getBarangayName]}})">
            <v-icon>mdi-arrow-left</v-icon>
        </div>
    </v-container>
</template>

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
