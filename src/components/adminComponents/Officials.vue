<template>
    <v-container class="officials-main">
        <div class="title">
            <h1>BARANGAY {{this.$store.getters["auth/getBarangayName"].toUpperCase()}} OFFICIALS</h1>
        </div>
        <div class="cards">
            <OfficialCard v-for="official in officials" :key="official.id" :official="official" @fetchInfo="getOfficials()"/>
        </div>

        <!-- Add New Education Button -->
        <v-btn
        @click="showAddSkOfficial = true"
        class="d-flex items-center justify-center w-auto px-15 py-10 text-lg"
        elevation="10"
        >
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-2">ADD SK OFFICIAL</span>
        </v-btn>

        <AddOfficial
            v-if="showAddSkOfficial"
            @fetchOfficialInfo="getOfficials()"
            @close="showAddSkOfficial = false">
        </AddOfficial>
    </v-container>
</template>

<script>
import OfficialCard from "./subcomponents/officials/OfficialCard.vue";
import AddOfficial from "./AddOfficial.vue";
import $ from 'jquery';

export default {
    components: {
        OfficialCard,
        AddOfficial
    },
    data() {
        return {
            officials: null,
            showAddSkOfficial: false,
            loading: false
        };
    },
    methods: {
        getOfficials() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=sk-officials`,
                type: 'POST',
                xhrFields: {
                withCredentials: true
                },
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    barangayId: this.$store.getters['auth/getBarangayId'],
                },
                success: (data) => {
                    this.officials = [data.data.skChairman, ...data.data.skMembers];
                },

                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                    let errorMsg = "An error occurred while processing your request.";
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMsg = jqXHR.responseJSON.message;
                    } else if (jqXHR.responseText) {
                        errorMsg = jqXHR.responseText;
                    }
                    this.requestError = errorMsg;
                    },
                complete: () => {
                    this.loading = false;
                }
            });
        },

        /**
         * Handles child events by closing the new achievement form
         * and emitting an event to refresh official information.
         */
         handleChildEvent(payload) {
            this.showNewEducation = false;
            this.editingIndex = null;

        },
    },
    created() {
        this.getOfficials();
    }
};
</script>

<style scoped>
.officials-main {
    padding: 4rem 7rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    gap: 4rem;
}
.cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 3rem;
}

h1 {
    will-change: transform, opacity;
    font-size: 3rem;
    font-weight: 900;
    text-align: center;
    background: linear-gradient(
        45deg,
        #0533a0,
        #ffffff,
        #DF2935,
        #d4d4d4,
        #FDCA40,
        #d4d4d4
    );
    background: linear-gradient(to left, #3772FF, #DF2935, #fffefe, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 2.5s linear infinite;
}

@keyframes animate-gradient {
    from {
    background-position: 200% 50%;
    }
    to {
    background-position: 0% 50%;
    }
}
</style>