<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import ThemeSwitcher from '../ThemeSwitcher.vue';

const router = useRouter();
const drawer = ref(true);

const menuObjs = [
    { menuName: "Dashboard", icon: "mdi-view-dashboard", to: "/admin/dashboard" },
    { menuName: "Officials", icon: "mdi-account-group", to: "/admin/officials" },
    { menuName: "Announcements", icon: "mdi-bullhorn", to: "/admin/announcements" },
    { menuName: "Achievements", icon: "mdi-trophy", to: "/admin/achievements" },
    { menuName: "Settings and Profile", icon: "mdi-cog", to: "/admin/settings" },
    { menuName: "Notices", icon: "mdi-bell", to: "/admin/notices" }
];
</script>

<template>
    <v-navigation-drawer v-model="drawer" app width="256">
        <!-- Logo and Barangay Name -->
        <v-list-item class="logo-container">
            <template v-slot:prepend>
                <v-avatar size="45">
                    <v-img src="/dist/Group.svg" alt="Barangay Logo"></v-img>
                </v-avatar>
            </template>
            <v-list-item-content>
                <v-list-item-title>BARANGAY</v-list-item-title>
                <v-list-item-subtitle>SAN FRANCISCO</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <!-- Navigation Menu -->
        <v-list density="compact" nav>
            <v-list-item v-for="menuObj in menuObjs" :key="menuObj.menuName" :to="menuObj.to" active-class="active">
                <template v-slot:prepend>
                    <v-icon>{{ menuObj.icon }}</v-icon>
                </template>
                <v-list-item-title>{{ menuObj.menuName }}</v-list-item-title>
            </v-list-item>
        </v-list>

        <v-spacer></v-spacer>

        <!-- Centered Theme Switcher -->
        <div class="theme-container">
            <ThemeSwitcher />
        </div>

        <!-- Logout Button at the Bottom Center -->
        <v-list-item class="logout-container">
            <v-btn block color="error" variant="outlined" @click="router.push('/logout')">
                <v-icon left>mdi-logout</v-icon>
                <span>LOG OUT</span>
            </v-btn>
        </v-list-item>
    </v-navigation-drawer>
</template>

<style scoped>
.active {
    background-color: rgba(255, 255, 255, 0.1);
}

.logo-container {
    display: flex;
    align-items: center;
    padding: 16px;
}

.v-navigation-drawer {
    display: flex;
    flex-direction: column;
    transition: width 0.3s;
}

/* Centering the Theme Switcher */
.theme-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 16px;
}

/* Logout Button at the Bottom */
.logout-container {
    position: absolute;
    bottom: 16px;
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 0 16px;
}

@media (max-width: 600px) {
    .v-navigation-drawer {
        width: 56px !important;
    }
}
</style>
