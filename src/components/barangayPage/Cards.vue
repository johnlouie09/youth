<template>
    <v-sheet class="main-barangay-officials" elevation="15">
        <v-card-title class="font-bold" font-bold="font-bold">
            SANGGUNIANG KABATAAN OFFICIALS
        </v-card-title>

        <div class="officials">
            <!-- SK Chairperson -->
            <OfficialCard 
                :official="skChairperson" 
                class="custom-card"
                @click="openDialog(skChairperson)"
            ></OfficialCard>

            <!-- SK Members Slider -->
            <div class="members">
                <v-slide-group
                    v-model="model"
                    selected-class="bg-success"
                    show-arrows
                    class="pa-4"
                >
                    <v-slide-group-item
                        v-for="(official, index) in officials"
                        :key="index"
                        v-slot="{ isSelected, toggle, selectedClass }"
                    >
                        <OfficialCard 
                            :class="['ml-5', 'mr-5', selectedClass, 'members-card', 'custom-card']" 
                            :official="official"
                            @click="openDialog(official)"
                        ></OfficialCard>
                    </v-slide-group-item>
                </v-slide-group>
            </div>
        </div>
        <!-- Dialog component should expose a method openDialog that accepts an official -->
        <DialogComponent ref="dialogComponent" />
    </v-sheet>
</template>

<script>
import DialogComponent from './DialogComponent.vue';
import OfficialCard from '../OfficialCard.vue';

export default {
    components: {
        DialogComponent,
        OfficialCard
    },
    data() {
        return {
            skChairperson: {
                id: 1,
                role: 'sk chairperson',
                img: '/public/Sangguniang_Kabataan_logo.svg',
                name: 'Cal Newport',
                motto: '"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, quos fuga tenetur totam"'
            },
            officials: [
                { id: 2, role: "Secretary", name: "Maria Santos", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Organizing for success." },
                { id: 3, role: "Treasurer", name: "Carlos Mendoza", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Ensuring financial integrity." },
                { id: 4, role: "Kagawad", name: "Ana Reyes", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Empowering youth voices." },
                { id: 5, role: "Kagawad", name: "Jose Lopez", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Striving for community progress." },
                { id: 6, role: "Kagawad", name: "Elena Garcia", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Championing transparency and justice." },
                { id: 7, role: "Kagawad", name: "Miguel Torres", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Building a better tomorrow." },
                { id: 8, role: "Kagawad", name: "Rosa Fernandez", img: "/public/Sangguniang_Kabataan_logo.svg", motto: "Uniting for community empowerment." }
            ],
            model: null,
            skPositions: [
                "SK Secretary",
                "SK Treasurer",
                "SK Kagawad 1",
                "SK Kagawad 2",
                "SK Kagawad 3",
                "SK Kagawad 4",
                "SK Kagawad 5",
                "SK Kagawad 6",
                "SK Kagawad 7",
                "SK Kagawad 8"
            ],
            dialogComponent: null
        };
    },
    methods: {
        openDialog(official) {
            // Pass the official data to the dialog component if needed
            // For example, the dialog component can have an openDialog method
            this.dialogComponent.openDialog(official);
        }
    },
    mounted() {
        // Assign the ref to a variable for easier access
        this.dialogComponent = this.$refs.dialogComponent;
    }
};
</script>

<style scoped>
@import "@/assets/cards.css";
@import "@/assets/fontEffects.css";

.main-barangay-officials {
    width: 100%;
    padding: 9rem 9rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 2rem;
    border-radius: 1rem;
}

.officials {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    gap: 5rem;
    width: 100%;
}

.members {
    width: 70%;
    height: 35vh;
    display: flex;
    justify-content: center;
}

.font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 900;
    font-size: 1.5rem;
}
</style>
