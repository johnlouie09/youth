<script setup>
import { ref, onMounted } from "vue";
import gsap from "gsap";

const isLoading = ref(true);

onMounted(() => {
    const tl = gsap.timeline({
        delay: 0.3,
        onComplete: () => {
            isLoading.value = false;
        },
    });

    tl.fromTo(
            ".preloader-svg",
            { opacity: 0, x: 50 },
            { opacity: 1, x: 0, duration: 1.5, ease: "power3.out" }
    );

    tl.to({}, { duration: 0 });

    tl.to(".preloader-svg", {
        opacity: 0,
        y: -50,
        duration: 1,
        ease: "power3.in",
    });

    tl.to(
            ".mil-preloader",
            {
                opacity: 0,
                duration: 1,
                ease: "power3.out",
            },
            "-=0.3"
    );
});
</script>

<template>
    <div v-if="isLoading" class="mil-preloader">
        <div class="mil-preloader-animation">
            <div class="mil-pos-abs mil-animation-2">
                <div class="mil-reveal-frame">
                    <img src="/youth.svg" alt="Youth Logo" class="preloader-svg" />
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
$dark: #111;
$accent: #ff5722;
$light: #fff;

.mil-preloader {
    position: fixed;
    z-index: 9;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: $dark;
    overflow: hidden;

    &-animation {
        opacity: 1;
        position: relative;
        height: 100vh;
        color: $light;
    }

    .mil-pos-abs {
        position: absolute;
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;

        .mil-reveal-frame {
            position: relative;
            padding: 0 30px;

            .mil-reveal-box {
                display: none;
            }

            .preloader-svg {
                width: 500px;
                height: auto;
            }
        }
    }
}
</style>
