<template>
<h1>Product Create</h1>
<ProductForm @submit="handleCreate" />
</template>

<script setup lang="ts">
import { defineComponent } from 'vue';
import ProductForm from './ProductForm.vue';
import { createProduct } from '@/api/services/productService';
import { ProductInterface } from '@/types/Product';

defineComponent ({
    name: 'ProductCreate',
    components: {
        ProductForm
    }
});

async function handleCreate(product: ProductInterface){
    try {
        console.log('aiai');
        product = await createProduct(product);
    } catch(error) {
        console.log(error);
    }
}
</script>