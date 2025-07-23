<template>
    <v-container class="main-barangay-officials elevation-20">
        <h1 class="w-full text-center font-extrabold">
            SANGGUNIANG KABATAAN OFFICIALS
        </h1>

        <div class="officials">
            <!-- SK Chairperson -->
            <OfficialCard 
                :officialProps="skChairperson || {}" 
                class="custom-card chairperson-card"
            />

            <!-- SK Members Slider -->
            <div class="members">
                <OfficialCard
                    v-for="(skMember, index) in skMembers"
                    :key="index"
                    v-slot="{ selectedClass }"
                    :class="[selectedClass, 'members-card', 'custom-card', 'mx-3 min-w-[20%]']"
                    :officialProps="skMember || {}"
                />
            </div>
        </div>
    </v-container>
</template>
  
  
<script>
import OfficialCard from './OfficialCard.vue';
import $ from 'jquery';

export default {
    name: 'Cards',
    props: {
        barangayId: {
            type: Number,
            required: true
        }
    },
    components: {
        OfficialCard
    },
    data() {
        return {
            // Assign the prop to a local data property for ease of use
            myBarangayId: this.barangayId,
            skChairperson: {},
            skMembers: {}
        };
    },
    methods: {
        async fetchSkOfficials() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            await $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=sk-officials`,
                type: 'POST',
                xhrFields: { withCredentials: true },
                headers: { 'X-CSRF-Token': csrfToken },
                // Use the local data property myBarangayId here
                data: { barangayId: this.myBarangayId },
                success: (data) => {
                    this.skChairperson = data.data.skChairman;
                    this.skMembers = data.data.skMembers;
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                    let errorMsg = "An error occurred while processing your request.";
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMsg = jqXHR.responseJSON.message;
                    } else if (jqXHR.responseText) {
                        errorMsg = jqXHR.responseText;
                    }
                },
                complete: () => {
                    // Optional: handle any completion logic
                }
            });
        }
    },
    created() {
        this.fetchSkOfficials();
    },
    watch: {
        // Watch the prop and update the local data if it changes
        barangayId(newVal) {
            this.myBarangayId = newVal;
            this.fetchSkOfficials();
        }
    }
};
</script>

<style scoped>
@import "@/assets/cards.css";
@import "@/assets/fontEffects.css";

.main-barangay-officials {
    width: 100%;
    height: auto;
    padding: 5rem 5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 3rem;
    border-radius: 1rem;
}

.officials {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    gap: 2.5rem;
    width: 100%;
}

.members {
    width: 100%;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

h1 {
    font-size: 2.3rem;
    background: linear-gradient(
        45deg,
        #0533a0,
        #ffffff,
        #DF2935,
        #FDCA40,
    );
    background: linear-gradient(to left, #3772FF, #fffefe, #DF2935, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 4s linear infinite;
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
  