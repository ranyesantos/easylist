<template>
    <div>
      <h1>Welcome to the Products Page</h1>
      <!-- The Products component will be rendered here -->
      <Products />
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import Products from '@/components/Products/ProductList.vue'; // Adjust path if needed

    export default defineComponent({
    name: 'ProductsPage',
    components: {
        Products, // Registering the Products component here
    },
    });
</script>

<style scoped>
/* Your styling here */
</style>
  