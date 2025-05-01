<template>
    <div>
      <h1>Welcome to the Products Page</h1>
      <!-- The Products component will be rendered here -->
      <Products />
      <Sizes />
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import Products from '@/components/Products/ProductList.vue'; // Adjust path if needed
    import Sizes from '@/components/Sizes/SizeList.vue';
    
    export default defineComponent({
        name: 'ProductsView',
        components: {
            Products, // Registering the Products component here
            Sizes
        },
    });
</script>

<style scoped>
/* Your styling here */
</style>
  