<template>
    <div class="docs-container">
        <h1>Message Dialog Usage Examples</h1>
        <p>Click on the buttons below to see the message dialog in action.</p>

        <section class="demo-section">
            <h2>Default Message Dialog</h2>
            <p>
                Opens the dialog using default values from the Vuex module (e.g., title "Message", message "Operation completed successfully.").
            </p>
            <button @click="openDefaultMessageDialog">Open Default Message Dialog</button>
        </section>

        <section class="demo-section">
            <h2>Custom Message Dialog</h2>
            <p>
                Opens the dialog with customized title, message, color, and OK button text. The OK callback here is synchronous.
            </p>
            <button @click="openCustomMessageDialog">Open Custom Message Dialog</button>
        </section>

        <section class="demo-section">
            <h2>Async Message Dialog</h2>
            <p>
                Opens the dialog with an asynchronous OK callback that simulates a delay before closing the dialog.
            </p>
            <button @click="openAsyncMessageDialog">Open Async Message Dialog</button>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'MessageDialogDemo',
        methods: {
            openDefaultMessageDialog() {
                // Using an empty payload to trigger default values.
                this.$store.commit('dialog/message/show', {
                    message: 'Awesome!'
                });
            },
            openCustomMessageDialog() {
                this.$store.commit('dialog/message/show', {
                    title: 'Custom Message',
                    message: 'This is a custom message dialog with a synchronous OK action.',
                    color: 'success',
                    okText: 'Understood',
                    onOk: () => {
                        console.log('Custom dialog OK clicked');
                        alert('Custom dialog OK clicked');
                    }
                });
            },
            async openAsyncMessageDialog() {
                this.$store.commit('dialog/message/show', {
                    title: 'Demo Async Dialog',
                    message: 'Please wait while we complete your request.',
                    color: 'info',
                    okText: 'Got it',
                    onOk: async () => {
                        // Simulate an asynchronous task (e.g., API call)
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        console.log('Async operation completed');
                    }
                });
            }
        }
    };
</script>

<style scoped>
    .docs-container {
        background-color: white;
        color: #222; /* Dark text color */
        padding: 2rem;
        max-width: 800px;
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
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
