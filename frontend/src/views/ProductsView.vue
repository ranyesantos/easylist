<template>
    <div>
        <div class="product-form">
            <ProductCreate />
        </div>
        <h1>Welcome to the Products Page</h1>
        <!-- <div class="products">
            <h2>Produtos</h2>
            <Products />
        </div>

        <div class="sizes">
            <h2>tamanhos</h2>
            <Sizes />
        </div>

        <div class="products">
            <h2>Cores</h2>
            <Colors />
        </div> -->
      
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import Products from '@/components/Products/ProductList.vue'; // Adjust path if needed
    import Sizes from '@/components/Sizes/SizeList.vue';
    import Colors from '@/components/Colors/ColorList.vue';
    import ProductCreate from '@/components/Products/ProductCreate.vue';

    export default defineComponent({
        name: 'ProductsView',
        components: {
            // Products, // Registering the Products component here
            // Sizes,
            // Colors,
            ProductCreate
        },
    });
</script>

<style scoped>
/* Your styling here */
</style>
  