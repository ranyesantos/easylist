<template>
    <div v-if="loading">Loading...</div>
    <ul v-else>
        <li v-for="size in sizes" :key="size.id" >
            {{ size.size_description }}
        </li>
    </ul>
</template>

<script setup lang="ts">
import { getAllSizes, SizeInterface } from '@/api/services/sizeService';
import { onMounted, reactive, ref } from 'vue'

let sizes = reactive<SizeInterface[]>([]);
const loading = ref(true);

onMounted(async () => {
    try {
        sizes = await getAllSizes();
        console.log('sizes', sizes);
    } finally {
        loading.value = false;
    }
});
</script>