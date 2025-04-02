<template>
    <v-container class="d-flex flex-column justify-evenly pa-0 elevation-10" style="width: 100%;">
        <!-- Card Title -->
        <v-card-title :class="['card-title', card.type]">
            {{ card.title }}
        </v-card-title>

        <v-card-text class="card-body d-flex">
            <!-- Dropdown for selecting month (returns the entire object) -->
            <v-select
                v-if="card.type === 'achievements' || card.type === 'announcements'"
                v-model="selectedMonth"
                :items="monthOptions"
                item-title="title"
                item-value="value"
                label="Select Month"
                outlined
                class="w-[60%] pa-0"
            />


            <v-container class="fill-height w-full justify-evenly pa-0">
                <div justify="center" class="pa-0">
                    <!-- MDI ICON -->
                    <v-icon :icon="card.icon" size="100"></v-icon>
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
                class="d-flex flex-col pa-0">
                    <span class='text-8xl font-extrabold'>{{ selectedCount }}</span>
                    <span class="text-xs font-bold">TOTAL</span>
                </div>

                <!--Announcements Section -->
                <div
                v-if="card.type === 'announcements'"
                justify="center"
                class="d-flex flex-col pa-0">
                    <span class='text-8xl font-extrabold'>{{ selectedCount }}</span>
                    <span class="text-sm font-bold">2025</span>
                </div>
                
            </v-container>
        </v-card-text>
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
        monthOptions() {
            const options = [];
            const monthlyData = this.card?.details?.monthly || {};

            for (const year in monthlyData) {
                const months = monthlyData[year];
                months.forEach(entry => {
                    options.push({
                        title: `${entry.month} - ${year}`,
                        value: { ...entry, year }
                    });
                });
            }
            return options;
        },
        selectedMonthData() {
            return this.selectedMonth || {};
        },
        selectedCount() {
            return this.selectedMonthData.count || 0;
        },
        formattedDate() {
            if (!this.selectedMonth) return '';
            return `${this.selectedMonth.month.toUpperCase()} - ${this.selectedMonth.year}`;
        }
    },
    watch: {
        monthOptions: {
            immediate: true,
            handler(newOptions) {
                if (newOptions.length && !this.selectedMonth) {
                    this.selectedMonth = newOptions[0].value;
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
    padding: 1rem;
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
    padding: 1rem 1rem 1.5rem 1rem;
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
