<template>
    <v-card class="official-card elevation-10" @click="fillDialog(official)">
        <v-avatar
        :image="official.img ? ($store.getters.base + 'public/OfficialImages/' + official.img) : '/OfficialImages/no-avatar.png'"
        cover
        alt="SK Logo"
        class="official-pic rounded-circle"
        ></v-avatar>
        <h3 class="text-lg uppercase font-extrabold ">{{ official.position }}</h3>
      <p class="font-italic text-sm">"{{ official.motto }}"</p>
    </v-card>
  </template>
  
<script>
export default {
    name: "OfficialCard",
    props: {
        officialProps: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            // Create a local copy so you can modify it if necessary.
            official: { ...this.officialProps },
        };
    },
    watch: {
        // Update the local copy if the parent prop changes.
        officialProps(newVal) {
            this.official = { ...newVal };
        }
    },
    methods: {
        async fillDialog(official) {
            this.$store.commit('viewOfficial/setViewOfficialOpenDialog', true);
            this.$store.commit('viewOfficial/setViewOfficialPersonalInfo', official);
        }
    }
};
</script>

<style scoped>
.official-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: .5rem;
    border-radius: 20px;
    padding: 3rem 2rem;
    background: linear-gradient(to bottom, #5B6A99 0%, #5B6A99 30%, transparent 30%, transparent 100%);
}

.chairperson-card {
    width: 600px;
}

.members-card {
    height: 300px;
    width: 350px;
    margin: .5rem 0;
}

.chairperson-card .official-pic{
    width: 150px;
    height: 150px;
}

.members-card .official-pic{
    width: 100px;
    height: 100px;
}

p {
    width: 70%;
    text-align: center;
}

/* When official-card width is below 380px, set image width to 100px */
@media (max-width: 380px) {
    .official-card .img .official-pic {
        width: 100px;
    }
}
</style>
