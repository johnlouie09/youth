<script setup>
import { useTheme } from 'vuetify'
import { onMounted } from 'vue'

const theme = useTheme()

const toggleTheme = () => {
    const newTheme = theme.global.name.value === 'dark' ? 'light' : 'dark'
    theme.global.name.value = newTheme
    localStorage.setItem('theme', newTheme)
}

onMounted(() => {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme) {
        theme.global.name.value = savedTheme
    }
})
</script>

<template>
    <v-btn @click="toggleTheme" :color="theme.global.name.value === 'dark' ? 'white' : 'dark'">
        <v-icon>{{ theme.global.name.value === 'dark' ? 'mdi-moon-waning-crescent' : 'mdi-lightbulb' }}</v-icon>
    </v-btn>
</template>
