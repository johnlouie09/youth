
<script setup>
</script>



<template>
    <div class="gallery" ref="flickityGallery">
        <div class="gallery-cell" v-for="(cell, index) in cells" :key="index">
            {{ index + 1 }}

        </div>
    </div>
 </template>




<style>




.carousel-title h2 {
    font-size: 3rem;
    background: linear-gradient(
    to right,
    #004BFF 0%,
    #99ABD2 29%,
    #FFBA00 56%,
    #FA873F 77%,
    #E2000F 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.carousel-title h1 {
    font-size: 4rem;
    color: white;
}



</style>


<script>
import Flickity from "flickity";
import "flickity/css/flickity.css";

export default {
    data() {
        return {
            flickity: null,
            cells: [1, 2, 3, 4, 5], // Number of slides
        };
    },
    mounted() {
        this.flickity = new Flickity(this.$refs.flickityGallery, {
            wrapAround: true,
        });
    },
    beforeUnmount() {
        if (this.flickity) {
            this.flickity.destroy();
        }
    },
};
</script>

<style scoped>
* {
    box-sizing: border-box;
}

.gallery {
    background: transparent;
}

.gallery-cell {
    width: 66%;
    height: 300px;
    margin-right: 10px;
    background: rgba(76, 82, 76, 0.68);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
    color: white;

}
</style>


