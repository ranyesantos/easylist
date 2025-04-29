<template>
  <div v-if="loading">Loading...</div>
  <ul v-else>
    <li v-for="product in products" :key="product.product_id">
      {{ product.name }} - {{ product.price }}
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { fetchProducts, Product } from '@/api/products';

  const products = ref<Product[]>([]);
  const loading = ref(true);

  onMounted(async () => {
    try {
      products.value = await fetchProducts();
    } finally {
      loading.value = false;
    }
  });
</script>

<style scoped>
/* Optional: your CSS here */
</style>
