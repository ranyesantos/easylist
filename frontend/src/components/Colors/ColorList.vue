<template>
    <div v-if="loading">Loading...</div>
    <ul v-else>
        <li v-for="color in colors" :key="color.id">
            {{ color.name }}
        </li>
    </ul>
</template>

<script setup lang="ts">
import { ColorInterface, getAllColors } from '@/api/services/colorService';
import { onMounted, reactive, ref } from 'vue';

let colors = reactive<ColorInterface[]>([]);
const loading = ref(true);

onMounted(async () => {
    try {
        colors = await getAllColors();
        console.log('colors', colors);
    } finally {
        loading.value = false;
    }
});
</script>

<style scoped>

</style>