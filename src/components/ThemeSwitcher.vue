<template>
    <v-btn @click="toggleTheme" icon :color="theme.global.name.value === 'dark' ? 'white' : 'black'">
        <v-icon class="w-full h-full">{{ theme.global.name.value === 'dark' ? 'mdi-weather-night' : 'mdi-white-balance-sunny' }}</v-icon>
    </v-btn>
</template>
<script>
import {useTheme} from 'vuetify'

export default {
    setup() {
        const theme = useTheme();

        const toggleTheme = () => {
            const newTheme = theme.global.name.value === 'dark' ? 'light' : 'dark';
            theme.global.name.value = newTheme;
            localStorage.setItem('theme', newTheme);
        };

        return {theme, toggleTheme};
    },
    mounted() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            this.theme.global.name.value = savedTheme;
        }
    }
}
</script>

<style scoped>

</style>