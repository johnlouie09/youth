<template>
    <v-navigation-drawer v-model="drawer" app width="280" class="relative d-flex flex-col pa-3 pt-7 pb-7">

        <!-- Toggle Button Fixed at the Top Right -->
        <v-btn
            class="toggle-drawer"
            icon
            @click="toggleDrawer"
        >
            <v-icon>{{ drawer ? 'mdi-menu-open' : 'mdi-menu' }}</v-icon>
        </v-btn>
        <!-- Logo and Barangay Name -->
        <v-list-item class="logo-container">
            <div class="d-flex justify-center items-center py-5" @click="openBarangayWebsite">
                <v-avatar size="45">
                    <v-img :src="$store.getters['base'] + '/Group.svg'" alt="Barangay Logo"></v-img>
                </v-avatar>

                <v-list-item>
                    <v-list-item-title>BARANGAY</v-list-item-title>
                    <v-list-item-subtitle>{{ barangaySlug.toUpperCase() }}</v-list-item-subtitle>
                </v-list-item>
            </div>
        </v-list-item>

        <!-- Navigation Menu -->
        <v-list density="compact" nav>
            <v-list-item
                v-for="menuObj in menuObjs"
                :key="menuObj.menuName"
                :to="menuObj.to"
                :class="{ active: isActive(menuObj.to) }"
                density="compact"
                class="mb-6"
                @click="navigate(menuObj.to)"
            >
                <template v-slot:prepend>
                    <v-icon>{{ menuObj.icon }}</v-icon>
                </template>

                <v-list-item-title
                    class="item"
                    style="font-size: 1rem;
                    height: auto;"
                >
                    {{ menuObj.menuName }}
                </v-list-item-title>
            </v-list-item>
        </v-list>

        <!-- Go to Barangay Website Button -->
        <v-btn
            class="d-flex items-center justify-center w-auto ma-auto"
            height="64"
            @click="openBarangayWebsite"
        >
            GO TO WEBSITE
        </v-btn>

        <!-- Logout Button at the Bottom Center -->
        <div class="logout absolute bottom-0 d-flex items-center justify-center w-[250px] py-10 gap-5">
        <ThemeSwitcher class="w-[10%]" />
        <v-btn class="pa-3 w-[50%] d-flex justify-center items-center" color="error" variant="outlined" @click="logout">
        <v-icon left>mdi-logout</v-icon>
        <span>LOG OUT</span>
        </v-btn>
        </div>
    </v-navigation-drawer>



    <v-navigation-drawer v-if="drawer === false" app width="100" class="relative d-flex flex-col pa-3 pt-7 pb-7">
        <v-list-item>
            <v-btn
                class="w-full"
                icon
                @click="toggleDrawer"
            >
                <v-icon>{{ drawer ? 'mdi-menu-open' : 'mdi-menu' }}</v-icon>
            </v-btn>
        </v-list-item>

        <!-- Logo and Barangay Name -->
        <v-list-item class="logo-container">
            <div class="d-flex justify-center items-center py-5" @click="openBarangayWebsite">
                <v-avatar size="30">
                    <v-img :src="$store.getters['base'] + '/Group.svg'" alt="Barangay Logo"></v-img>
                </v-avatar>
            </div>
        </v-list-item>

        <!-- Navigation Menu -->
        <v-list density="compact" nav>
            <v-list-item
                v-for="menuObj in menuObjs"
                :key="menuObj.menuName"
                :to="menuObj.to"
                :class="{ active: isActive(menuObj.to) }"
                density="compact"
                class="mb-6 d-flex justify-center items-center"
                @click="navigate(menuObj.to)"
            >
                <v-icon>{{ menuObj.icon }}</v-icon>
            </v-list-item>
        </v-list>

        <!-- Logout Button at the Bottom Center -->
        <div class="absolute bottom-0 d-flex flex-col items-center justify-center gap-5">
            <ThemeSwitcher/>
                <v-btn class="d-flex justify-center pa-0 items-center" color="error" variant="outlined" @click="logout">
                <v-icon>mdi-logout</v-icon>
            </v-btn>
        </div>
    </v-navigation-drawer>
</template>
  
<script>
import ThemeSwitcher from '../ThemeSwitcher.vue';
import $ from 'jquery';

export default {
    components: { ThemeSwitcher },
    data() {
        return {
            drawer: true,
        };
    },
    computed: {
        barangaySlug() {
            const user = this.$store.getters['auth/getUser'];
            return user && user.barangay ? user.barangay.slug : 'default-slug';
        },
        // Build the menu objects dynamically using the slug from the URL.
        menuObjs() {
            return [
                { menuName: "Dashboard", icon: "mdi-view-dashboard", to: `/admin/${this.barangaySlug}/dashboard`},
                { menuName: "Officials", icon: "mdi-account-group", to: `/admin/${this.barangaySlug}/officials`},
                { menuName: "Announcements", icon: "mdi-bullhorn", to: `/admin/${this.barangaySlug}/announcements`},
                { menuName: "Achievements", icon: "mdi-trophy", to: `/admin/${this.barangaySlug}/achievements`},
                { menuName: "Youth Request", icon: "mdi-bell", to: `/admin/${this.barangaySlug}/youth-request`},
                { menuName: "Settings and Profile", icon: "mdi-cog", to: `/admin/${this.barangaySlug}/settings` },
            ];
        },
        barangayName() {
            return this.$store.getters['auth/getBarangayName'];
        }
    },
    methods: {
        navigate(path) {
            this.$router.push(path);
        },
        logout() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            $.ajax({
                type: 'POST', xhrFields: { withCredentials: true },
                url: `${this.$store.getters['api_base']}?e=sk-official&a=logout`,
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    username: this.$store.getters['auth/getUser'].sk_official.username
                },
                success: () => {
                    this.$store.commit('auth/setUser', null);
                    this.$router.replace({ name: 'login'});
                },
                error: (error) => {
                    console.error("Logout error: ", error);
                }
            });
        },
        isActive(menuRoute) {
            return this.$route.path.startsWith(menuRoute);
        },
        openBarangayWebsite() {
            // Resolve the URL using Vue Router
            // Ensure that your router configuration has a route named 'barangay-website'
            const resolvedRoute = this.$router.resolve({ name: 'barangay-landingpage', params: { slug: this.barangaySlug } });
            // Open the resolved URL in a new window
            window.open(resolvedRoute.href, '_blank');
        },
        toggleDrawer() {
            this.drawer = !this.drawer;
        },
    }
};
</script>

<style scoped>
.active {
    background-color: rgba(255, 255, 255, 0.1);
}

.v-navigation-drawer {
    display: flex;
    flex-direction: column;
    transition: width 0.3s;
}

/* Toggle Button Styles */
.toggle-drawer {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2000;
}
</style>
