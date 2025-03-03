<template>
    <footer class="text-white py-12 fixed bottom-0 left-0 w-full" style="background-color: rgb(35,35,35);">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo and Text -->
            <div class="flex items-center" style="margin-left: 100px;">
                <div class="logo" style="margin-left: 20px; margin-top: 15px;">
                    <img :src="`${$store.getters['base']}Flogo.svg`" alt="Logo" class="h-5 w-20 scale-700" />
                </div>
            </div>
        </div>
    </footer>
</template>

