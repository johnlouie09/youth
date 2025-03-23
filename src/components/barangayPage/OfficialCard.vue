<template>
    <v-card class="official-card" elevation="4" @click="fillDialog(official)">
        <div class="img">
            <img 
                :src="official.img || '/public/OfficialImages/no-avatar.jpg'"
                alt="SK Logo" 
                class="rounded-circle"
            >
            <h3 class="text-h6 font-weight-medium">{{ official.position }}</h3>
        </div>
        <p>{{ official.motto }}</p>    
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
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    max-width: 450px;
    width: 100%;
    height: 90%;
    border-radius: 1rem;
    gap: 1rem;
    padding: 3rem 1rem;
    background: linear-gradient(to bottom, #5B6A99 0%, #5B6A99 30%, transparent 30%, transparent 100%);
    min-width: 300px;
}

.official-card .img {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.members-card {
    padding: 1.5rem .5rem;
}

.members-card .img img {
    width: 100px;
}

.img img {
    width: 150px;
}

p {
    width: 70%;
    text-align: center;
}

/* When official-card width is below 380px, set image width to 100px */
@media (max-width: 380px) {
    .official-card .img img {
        width: 100px;
    }
}
</style>
