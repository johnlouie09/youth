<script setup>
import {useTheme} from 'vuetify'

// Access Vuetify's theme functionality
const theme = useTheme()

// Toggle between light and dark themes
const toggleTheme = () => {
    theme.global.name.value = theme.global.name.value === 'dark' ? 'light' : 'dark'
}
</script>

<template>
    <v-btn @click="toggleTheme" :color="theme.global.name.value === 'dark' ? 'yellow' : 'blue'">
        {{ theme.global.name.value === 'dark' ? 'Switch to Light' : 'Switch to Dark' }}
    </v-btn>
</template>
