<script setup>
    import { reactive } from 'vue';

    const menuObjs = reactive([
        { menuName: "Dashboard", icon: "/public/adminAssets/sidebarIcon/dashboard.svg", to:"/admin/dashboard"},
        { menuName: "Officials", icon: "/public/adminAssets/sidebarIcon/officials.svg", to:"/admin/officials"},
        { menuName: "Announcements", icon: "/public/adminAssets/sidebarIcon/announcements.svg", to:"/admin/announcements" },
        { menuName: "Achievements", icon: "/public/adminAssets/sidebarIcon/achievements.svg", to:"/admin/achievements" },
        { menuName: "Settings and profile", icon: "/public/adminAssets/sidebarIcon/settings.svg", to:"/admin/settings" },
        { menuName: "Notices", icon: "/public/adminAssets/sidebarIcon/notices.svg", to:"/admin/notices" }
    ]);
</script>

<template>
    <nav>
        <!-- Logo and Barangay Name -->
        <div class="logo-title">
            <div class="logo-container">
                <img src="/dist/Group.svg" alt="Barangay Logo" class="logo">
            </div>
            
            <div class="barangay-name">
                <span>BARANGAY</span>
                <h4>SAN FRANCISCO</h4>
            </div>

            <img src="/public/adminAssets/SidebarOff.svg" alt="Sidebar Toggle" class="sidebar-icon">
        </div>

        <!-- Navigation Menu -->
        <ul>
            <router-link class="routes" v-for="menuObj in menuObjs" :key="menuObj.menuName" :to="menuObj.to" >
                <li>
                    <img :src="menuObj.icon" :alt="`${menuObj.menuName} Icon`">
                    <span>{{ menuObj.menuName }}</span>
                </li>
            </router-link>
        </ul>

        <!-- Logout Button -->
        <button class="logout-button">
            <img src="/public/adminAssets/logout.svg" alt="Logout Icon">
            <span>LOG OUT</span>
        </button>
    </nav>
</template>

<style scoped>
    nav {
        background-color: #282828;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
        padding: 28px 16px;
        position: sticky;
    }

    /* LOGO SECTION */
    .logo-title {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 10px;
        gap: 0.5rem;
    }

    .logo-container {
        background-color: #2E2E2E;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 0.5rem;
    }

    .logo {
        height: 70%;
    }

    .barangay-name {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .barangay-name span {
        font-size: 8px;
    }

    .barangay-name h4 {
        font-family: 'Kumbh Sans', sans-serif;
        font-weight: 700;
    }

    .sidebar-icon {
        height: 20px;
        width: 20px;
        margin-left: auto;
        cursor: pointer;
    }

    /* MENU LIST */
    .routes {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 1.5rem;
        padding: 0;
    }

    ul {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    li {
        display: flex;
        align-items: flex-start;
        width: 100%;
        padding: 10px 20px;
        gap: 8px;
        border-radius: 0.25rem;
        transition: background 0.3s;
    }

    li:hover {
        background-color: #777777;
    }

    /* LOGOUT BUTTON */
    .logout-button {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 1px solid white;
        padding: 10px 20px;
        border-radius: 0.5rem;
        background: none;
        color: white;
        cursor: pointer;
        transition: background 0.3s;
    }


    .routes.active li {
    background-color: rgba(255, 255, 255, 0.1); /* Highlight active route */
    transition: background 0.3s;
    }
    


</style>