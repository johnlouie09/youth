<template>
    <div class="docs-container">
        <h1>Toast Notification Usage Examples</h1>
        <p>
            Click on the buttons below to display toast notifications with various types, positions, and custom settings.
        </p>

        <!-- Plain Toasts (Generic) -->
        <section class="demo-section">
            <h2>Plain Toasts (Generic)</h2>
            <button style="background-color: #17a2b8;" @click="openPlainToastTopLeft">
                Plain: top-left
            </button>
            <button style="background-color: #17a2b8;" @click="openPlainToastTopRight">
                Plain: top-right
            </button>
            <button style="background-color: #17a2b8;" @click="openPlainToastBottomLeft">
                Plain: bottom-left
            </button>
            <button style="background-color: #17a2b8;" @click="openPlainToastBottomRight">
                Plain: bottom-right
            </button>
            <button style="background-color: #17a2b8;" @click="openPlainToastTop">
                Plain: top
            </button>
            <button style="background-color: #17a2b8;" @click="openPlainToastBottom">
                Plain: bottom
            </button>
        </section>

        <!-- Success Toasts -->
        <section class="demo-section">
            <h2>Success Toasts</h2>
            <button style="background-color: #28a745;" @click="openSuccessToastTopLeft">
                Success: top-left
            </button>
            <button style="background-color: #28a745;" @click="openSuccessToastTopRight">
                Success: top-right
            </button>
            <button style="background-color: #28a745;" @click="openSuccessToastBottomLeft">
                Success: bottom-left
            </button>
            <button style="background-color: #28a745;" @click="openSuccessToastBottomRight">
                Success: bottom-right
            </button>
            <button style="background-color: #28a745;" @click="openSuccessToastTop">
                Success: top
            </button>
            <button style="background-color: #28a745;" @click="openSuccessToastBottom">
                Success: bottom
            </button>
        </section>

        <!-- Error Toasts -->
        <section class="demo-section">
            <h2>Error Toasts</h2>
            <button style="background-color: #dc3545;" @click="openErrorToastTopLeft">
                Error: top-left
            </button>
            <button style="background-color: #dc3545;" @click="openErrorToastTopRight">
                Error: top-right
            </button>
            <button style="background-color: #dc3545;" @click="openErrorToastBottomLeft">
                Error: bottom-left
            </button>
            <button style="background-color: #dc3545;" @click="openErrorToastBottomRight">
                Error: bottom-right
            </button>
            <button style="background-color: #dc3545;" @click="openErrorToastTop">
                Error: top
            </button>
            <button style="background-color: #dc3545;" @click="openErrorToastBottom">
                Error: bottom
            </button>
        </section>

        <!-- Warning Toasts -->
        <section class="demo-section">
            <h2>Warning Toasts</h2>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastTopLeft">
                Warning: top-left
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastTopRight">
                Warning: top-right
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastBottomLeft">
                Warning: bottom-left
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastBottomRight">
                Warning: bottom-right
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastTop">
                Warning: top
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openWarningToastBottom">
                Warning: bottom
            </button>
        </section>

        <!-- Info Toasts -->
        <section class="demo-section">
            <h2>Info Toasts</h2>
            <button style="background-color: #17a2b8;" @click="openInfoToastTopLeft">
                Info: top-left
            </button>
            <button style="background-color: #17a2b8;" @click="openInfoToastTopRight">
                Info: top-right
            </button>
            <button style="background-color: #17a2b8;" @click="openInfoToastBottomLeft">
                Info: bottom-left
            </button>
            <button style="background-color: #17a2b8;" @click="openInfoToastBottomRight">
                Info: bottom-right
            </button>
            <button style="background-color: #17a2b8;" @click="openInfoToastTop">
                Info: top
            </button>
            <button style="background-color: #17a2b8;" @click="openInfoToastBottom">
                Info: bottom
            </button>
        </section>

        <!-- Custom Toasts -->
        <section class="demo-section">
            <h2>Custom Toasts</h2>
            <button style="background-color: #6f42c1;" @click="openCustomToastTopLeft">
                Custom: top-left
            </button>
            <button style="background-color: #6f42c1;" @click="openCustomToastTopRight">
                Custom: top-right
            </button>
            <button style="background-color: #6f42c1;" @click="openCustomToastBottomLeft">
                Custom: bottom-left
            </button>
            <button style="background-color: #6f42c1;" @click="openCustomToastBottomRight">
                Custom: bottom-right
            </button>
            <button style="background-color: #6f42c1;" @click="openCustomToastTop">
                Custom: top
            </button>
            <button style="background-color: #6f42c1;" @click="openCustomToastBottom">
                Custom: bottom
            </button>
        </section>

        <!-- Persistent Toasts (Duration 0, timed: false) -->
        <section class="demo-section">
            <h2>Persistent Toasts (Duration 0)</h2>
            <p>
                These toasts will not auto-dismiss because they are persistent (duration: 0, timed: false).
            </p>
            <button style="background-color: #28a745;" @click="openPersistentSuccessToastTopLeft">
                Persistent Success: top-left
            </button>
            <button style="background-color: #dc3545;" @click="openPersistentErrorToastTopRight">
                Persistent Error: top-right
            </button>
            <button style="background-color: #ffc107; color: black;" @click="openPersistentWarningToastBottomLeft">
                Persistent Warning: bottom-left
            </button>
            <button style="background-color: #17a2b8;" @click="openPersistentInfoToastBottomRight">
                Persistent Info: bottom-right
            </button>
            <button style="background-color: #17a2b8;" @click="openPersistentPlainToastTop">
                Persistent Plain: top
            </button>
            <button style="background-color: #6f42c1;" @click="openPersistentCustomToastBottom">
                Persistent Custom: bottom
            </button>
        </section>

    </div>
</template>

<script>
    export default {
        name: 'ToastNotificationDemo',
        methods: {
            // Plain Toasts
            openPlainToastTopLeft() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at top-left',
                    position: 'top-left'
                });
            },
            openPlainToastTopRight() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at top-right',
                    position: 'top-right'
                });
            },
            openPlainToastBottomLeft() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at bottom-left',
                    position: 'bottom-left'
                });
            },
            openPlainToastBottomRight() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at bottom-right',
                    position: 'bottom-right'
                });
            },
            openPlainToastTop() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at top',
                    position: 'top'
                });
            },
            openPlainToastBottom() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Plain toast at bottom',
                    position: 'bottom'
                });
            },

            // Success Toasts
            openSuccessToastTopLeft() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at top-left',
                    position: 'top-left'
                });
            },
            openSuccessToastTopRight() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at top-right',
                    position: 'top-right'
                });
            },
            openSuccessToastBottomLeft() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at bottom-left',
                    position: 'bottom-left'
                });
            },
            openSuccessToastBottomRight() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at bottom-right',
                    position: 'bottom-right'
                });
            },
            openSuccessToastTop() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at top',
                    position: 'top'
                });
            },
            openSuccessToastBottom() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Success toast at bottom',
                    position: 'bottom'
                });
            },

            // Error Toasts
            openErrorToastTopLeft() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at top-left',
                    position: 'top-left'
                });
            },
            openErrorToastTopRight() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at top-right',
                    position: 'top-right'
                });
            },
            openErrorToastBottomLeft() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at bottom-left',
                    position: 'bottom-left'
                });
            },
            openErrorToastBottomRight() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at bottom-right',
                    position: 'bottom-right'
                });
            },
            openErrorToastTop() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at top',
                    position: 'top'
                });
            },
            openErrorToastBottom() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Error toast at bottom',
                    position: 'bottom'
                });
            },

            // Warning Toasts
            openWarningToastTopLeft() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at top-left',
                    position: 'top-left'
                });
            },
            openWarningToastTopRight() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at top-right',
                    position: 'top-right'
                });
            },
            openWarningToastBottomLeft() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at bottom-left',
                    position: 'bottom-left'
                });
            },
            openWarningToastBottomRight() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at bottom-right',
                    position: 'bottom-right'
                });
            },
            openWarningToastTop() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at top',
                    position: 'top'
                });
            },
            openWarningToastBottom() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Warning toast at bottom',
                    position: 'bottom'
                });
            },

            // Info Toasts
            openInfoToastTopLeft() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at top-left',
                    position: 'top-left'
                });
            },
            openInfoToastTopRight() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at top-right',
                    position: 'top-right'
                });
            },
            openInfoToastBottomLeft() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at bottom-left',
                    position: 'bottom-left'
                });
            },
            openInfoToastBottomRight() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at bottom-right',
                    position: 'bottom-right'
                });
            },
            openInfoToastTop() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at top',
                    position: 'top'
                });
            },
            openInfoToastBottom() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Info toast at bottom',
                    position: 'bottom'
                });
            },

            // Custom Toasts
            openCustomToastTopLeft() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at top-left with longer duration.',
                    type: 'info',
                    position: 'top-left',
                    duration: 5000
                });
            },
            openCustomToastTopRight() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at top-right with longer duration.',
                    type: 'info',
                    position: 'top-right',
                    duration: 5000
                });
            },
            openCustomToastBottomLeft() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at bottom-left with longer duration.',
                    type: 'info',
                    position: 'bottom-left',
                    duration: 5000
                });
            },
            openCustomToastBottomRight() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at bottom-right with longer duration.',
                    type: 'info',
                    position: 'bottom-right',
                    duration: 5000
                });
            },
            openCustomToastTop() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at top with longer duration.',
                    type: 'info',
                    position: 'top',
                    duration: 5000
                });
            },
            openCustomToastBottom() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Custom Toast',
                    message: 'Custom toast at bottom with longer duration.',
                    type: 'info',
                    position: 'bottom',
                    duration: 5000
                });
            },

            // Persistent Toasts (Duration 0, timed: false)
            openPersistentSuccessToastTopLeft() {
                this.$store.dispatch('dialog/toast/success', {
                    message: 'Persistent success toast at top-left',
                    position: 'top-left',
                    duration: 0,
                    timed: false
                });
            },
            openPersistentErrorToastTopRight() {
                this.$store.dispatch('dialog/toast/error', {
                    message: 'Persistent error toast at top-right',
                    position: 'top-right',
                    duration: 0,
                    timed: false
                });
            },
            openPersistentWarningToastBottomLeft() {
                this.$store.dispatch('dialog/toast/warning', {
                    message: 'Persistent warning toast at bottom-left',
                    position: 'bottom-left',
                    duration: 0,
                    timed: false
                });
            },
            openPersistentInfoToastBottomRight() {
                this.$store.dispatch('dialog/toast/info', {
                    message: 'Persistent info toast at bottom-right',
                    position: 'bottom-right',
                    duration: 0,
                    timed: false
                });
            },
            openPersistentPlainToastTop() {
                this.$store.dispatch('dialog/toast/show', {
                    message: 'Persistent plain toast at top',
                    position: 'top',
                    duration: 0,
                    timed: false
                });
            },
            openPersistentCustomToastBottom() {
                this.$store.dispatch('dialog/toast/show', {
                    title: 'Persistent Custom Toast',
                    message: 'Persistent custom toast at bottom',
                    type: 'info',
                    position: 'bottom',
                    duration: 0,
                    timed: false
                });
            }
        }
    };
</script>

<style scoped>
    .docs-container {
        background-color: white;
        color: #222;
        padding: 2rem;
        max-width: 900px;
        margin: 0 auto;
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }
    .demo-section {
        background-color: white;
        color: #222;
        margin-bottom: 2rem;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    h1, h2, p {
        background-color: white;
        color: #222;
    }
    button {
        padding: 0.5rem 1rem;
        border: none;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        margin: 0.25rem;
    }
    button:hover {
        opacity: 0.9;
    }
</style>
