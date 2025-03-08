<template>
    <div>
        <div
            v-if="drawer"
            class="overlay"
            :style="{ background: overlayColor }"
            @click="drawer = false"
        ></div>

        <v-navigation-drawer v-model="drawer" temporary class="custom-drawer">
            <v-list-item class="avatar-container">
                <template v-slot:prepend>
                    <v-avatar size="150">
                        <img src="/youth.svg" alt="Youth Avatar" />
                    </v-avatar>
                </template>
            </v-list-item>

            <v-list density="compact" nav>
                <router-link to="/">   <v-list-item prepend-icon="mdi-view-dashboard" title="Home" value="home">

                </v-list-item></router-link>
                <v-list-item prepend-icon="mdi-forum" title="About" value="about"></v-list-item>

                <!-- Show feedback form only on /san-francisco -->
                <FeedbackForm v-if="showFeedbackForm" />

                <v-list><ThemeSwitcher/></v-list>
            </v-list>
        </v-navigation-drawer>

        <v-btn icon class="menu-btn" @click.stop="drawer = !drawer">
            <v-icon>{{ drawer ? 'mdi-alpha-x-box' : 'mdi-microsoft-xbox-controller-menu' }}</v-icon>
        </v-btn>
    </div>
</template>
<script>
import { useTheme } from 'vuetify';
import ThemeSwitcher from './ThemeSwitcher.vue';
import FeedbackForm from './FeedbackForm.vue';

export default {
    components: {
        ThemeSwitcher,
        FeedbackForm
    },
    data() {
        return {
            drawer: false,
        };
    },
    computed: {
        showFeedbackForm() {
            return this.$route.path === '/san-francisco';
        },
        overlayColor() {
            return this.theme.global.current.value.dark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(255, 255, 255, 0.3)';
        }
    },
    setup() {
        const theme = useTheme();
        return { theme };
    }
};
</script>

<style scoped>
/* Drawer Styling */
.custom-drawer {
    position: fixed !important;
    z-index: 1100 !important;
}

/* Overlay with Theme-based Background */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(50px);
    z-index: 1099;
    transition: opacity 0.3s ease-in-out;
}

/* Position the menu button at the top right */
.menu-btn {
    position: fixed;
    top: 16px;
    right: 16px;
    z-index: 1200;
}

.avatar-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>