<template>
    <v-container class="d-flex justify-evenly flex-row pa-0" style="width: 40%; min-width: 500px">
        <v-card class="dashboard-card" elevation="10">
            <!-- Card Title -->
            <v-card-title :class="['card-title', card.type]">
                {{ card.title }}
            </v-card-title>

            <v-card-text class="card-body d-flex">
                <!-- Dropdown for selecting month (returns the entire object) -->
                <v-select
                v-if="card.type === 'achievements'"
                v-model="selectedMonth"
                :items="monthOptions"
                label="Select Month"
                return-object
                outlined
                class="w-[50%] pt-5"
                ></v-select>

                <v-container class="fill-height w-full justify-evenly">
                    <div justify="center" class="pa-0">
                        <!-- MDI ICON -->
                        <v-icon :icon="card.icon" size="125"></v-icon>
                    </div>

                    <!-- Officials Section -->
                    <div v-if="card.type === 'officials'" justify="center" align="center">
                        <article cols="12" class="flex flex-col justify-start items-start">
                            <p v-for="(number, position) in card.details" :key="position">
                            <span class="number me-2">{{ number }}</span>
                            {{ position }}
                            </p>
                        </article>
                    </div>

                    <!-- Achievements -->
                    <div
                    v-if="card.type === 'achievements'"
                    justify="center"
                    class="d-flex flex-col">
                        <span class='text-8xl font-extrabold'>{{ selectedCount }}</span>
                        <span class="text-xs font-bold">TOTAL</span>
                    </div>

                    <!--Announcements Section -->
                    <div
                    v-if="card.type === 'announcements'"
                    justify="center"
                    class="d-flex flex-col pa-10">
                        <span class='text-8xl font-extrabold'>{{ card.details }}</span>
                        <span class="text-sm font-bold">2025</span>
                    </div>
                    
                </v-container>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    props: {
        card: Object, // Receiving `card` prop dynamically
    },
    data() {
        return {
            selectedMonth: null,
        };
    },
    computed: {
        // Get the monthly data from the card details.
        // Assumes that card.details.monthly is an object with one key (e.g., "2025")
        monthlyData() {
        if (
            this.card &&
            this.card.details &&
            this.card.details.monthly &&
            Object.keys(this.card.details.monthly).length
        ) {
            // Get the first year key
            const yearKey = Object.keys(this.card.details.monthly)[0];
            return this.card.details.monthly[yearKey] || [];
        }
        return [];
        },
        // Build an array of month names for the dropdown.
        monthOptions() {
        return this.monthlyData.map(item => item.month);
        },
        // Find the data for the currently selected month.
        selectedMonthData() {
        return this.monthlyData.find(item => item.month === this.selectedMonth) || {};
        },
        // Return the count for the selected month (default to 0).
        selectedCount() {
        return this.selectedMonthData.count || 0;
        },
        // Format a display string combining the selected month and its year.
        formattedDate() {
        if (!this.selectedMonth) return "";
        // Get the first year key from the monthly data (for this example).
        const yearKey = Object.keys(this.card.details.monthly)[0];
        return `${this.selectedMonth.toUpperCase()} - ${yearKey}`;
        }
    },
    watch: {
        // When month options change, set the default selected month if not already set.
        monthOptions: {
        immediate: true,
        handler(newOptions) {
            if (newOptions.length && !this.selectedMonth) {
            this.selectedMonth = newOptions[0];
            }
        }
        }
    }
};
</script>

<style scoped>
/* Base Card Styling */
.dashboard-card {
    width: 100%;
    height: auto;
    background-color: var(--v-theme-surface);
    border-radius: 0.5rem;
    box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    
}

/* Title Styles */
.card-title {
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    border-radius: 0.5rem 0.5rem 0 0;
    font-weight: bold;
    padding: 10px;
}

/* Dynamic Colors */
.officials {
    background-color: rgba(55, 114, 255, 0.7);
}

.achievements {
    background-color: rgba(223, 41, 53, 0.7);
}

.announcements {
    background-color: rgba(253, 202, 64, 0.7);
}

/* Card Body */
.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-grow: 1;
}

/* Officials List */
.number {
    font-weight: bold;
    font-size: 22px;
}

/* Achievements & Announcements */
h4 {
    font-size: 1rem;
    font-weight: 700;
}

h2 {
    font-size: 5rem;
    font-weight: bolder;
    line-height: 5rem;
}

h5 {
    font-size: 0.5rem;
    font-weight: bolder;
}
</style>
