<template>
  <div v-if="loading">Loading...</div>
  <ul v-else>
    <li v-for="product in products" :key="product.product_id">
      {{ product.name }} - {{ product.price }}
    </li>
  </ul>
</template>

<script setup lang="ts">
  import { ref, onMounted, reactive } from 'vue';
  import { getAllProducts } from '@/api/services/productService';
  import { ProductInterface } from '@/types/Product';

  let products = reactive<ProductInterface[]>([]);
  const loading = ref(true);

  onMounted(async () => {
    try {
      products = await getAllProducts();
      console.log(products);
    } finally {
      loading.value = false;
    }
  });
</script>

<style scoped>
/* Optional: your CSS here */
</style>
