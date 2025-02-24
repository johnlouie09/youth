<template>
    <div class="docs-container">
        <h1>Confirm Dialog Usage Examples</h1>
        <p>Click on the buttons below to see the confirm dialog in action.</p>

        <section class="demo-section">
            <h2>Plain Confirm Dialog</h2>
            <p>
                Opens the dialog with a custom prompt and a Yes callback only.
            </p>
            <button @click="openPlainConfirmDialog">Open Plain Confirm Dialog</button>
        </section>

        <section class="demo-section">
            <h2>Custom Confirm Dialog</h2>
            <p>
                Opens the dialog with customized title, prompt, Yes/No texts, and both callbacks.
            </p>
            <button @click="openCustomConfirmDialog">Open Custom Confirm Dialog</button>
        </section>

        <section class="demo-section">
            <h2>Async Confirm Dialog</h2>
            <p>
                Opens the dialog with asynchronous callbacks that simulate delays.
            </p>
            <button @click="openAsyncConfirmDialog">Open Async Confirm Dialog</button>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'ConfirmDialogDemo',
        methods: {
            openPlainConfirmDialog() {
                // Only providing a custom prompt and the Yes callback, relying on defaults for other properties.
                this.$store.commit('dialog/confirm/show', {
                    prompt: 'Do you want to continue?',
                    onConfirm: () => {
                        console.log('Plain confirm: confirmed.');
                        alert('Plain confirm: confirmed.');
                    }
                });
            },
            openCustomConfirmDialog() {
                // Providing additional customizations including title, colors, and custom button texts.
                this.$store.commit('dialog/confirm/show', {
                    title: 'Custom Confirm',
                    prompt: 'Are you sure you want to proceed with the custom action?',
                    color: 'warning',
                    yesText: 'Proceed',
                    noText: 'Abort',
                    onConfirm: () => {
                        console.log('Custom confirm: confirmed.');
                        alert('Custom confirm: confirmed.');
                    },
                    onCancel: () => {
                        console.log('Custom confirm: cancelled.');
                    }
                });
            },
            async openAsyncConfirmDialog() {
                // Demonstrates asynchronous callbacks for both Yes and No actions.
                this.$store.commit('dialog/confirm/show', {
                    title: 'Async Confirm Dialog',
                    prompt: 'Do you want to perform the asynchronous operation?',
                    color: 'info',
                    yesText: 'Yes, do it',
                    noText: 'No, cancel',
                    onConfirm: async () => {
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        console.log('Async confirm: confirmed.');
                    },
                    onCancel: async () => {
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        console.log('Async confirm: cancelled.');
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
