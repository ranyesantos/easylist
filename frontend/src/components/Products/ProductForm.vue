<template>
<div class="container mt-4">
  <form @submit.prevent="handleSubmit">
    <div class="mb-3">
      <label for="name" class="form-label">Product Name</label>
      <input
        type="text"
        id="name"
        class="form-control"
        v-model="formData.name"
        required
      />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea
        id="description"
        class="form-control"
        v-model="formData.description"
        rows="4"
        required
      ></textarea>
    </div>

    <div
      class="mb-3"
      v-for="(productColor, index) in formData.product_colors"
      :key="index"
      >
      <h5>Color #{{ index + 1 }}</h5>

      <!-- Select Color -->
      <div class="mb-2">
        <label class="form-label">Select Color</label>
        <select
          class="form-select"
          v-model="productColor.color_id"
          required
        >
          <option disabled value="">Please select a color</option>
          <option
            v-for="color in colors"
            :key="color.id"
            :value="color.id"
          >
            {{ color.name }}
          </option>
        </select>
      </div>

    </div>
    <button type="submit" class="btn btn-primary mt-2">submit</button>
  </form>
</div>
</template>
  
<script setup lang="ts">
import { ProductInterface } from '@/types/Product'
import { onMounted, ref } from 'vue'
import { ColorInterface, getAllColors } from '@/api/services/colorService';

const props = defineProps<{
  product?: ProductInterface
}>()

const emit = defineEmits<{
  (e: 'submit', data: ProductInterface): void
}>()

let colors = ref<ColorInterface[]>([]);
onMounted(async () => {
  colors.value = await getAllColors();
});
console.log(colors);

const formData = ref<ProductInterface>(
  props.product
    ? { ...props.product } : {
      product_id: 0,
      name: '',
      description: '',
      product_colors: [
        {
          product_color_id: 0,
          name: '',
          picture_url: '',
          color_id: 0,
          product_size:[
            {
              price: 0,
              size_description: ''
            }
          ]
        }
      ]
    }
)
console.log('formData', formData.value);
function handleSubmit() {
  emit('submit', formData.value)
  console.log('submitee');
}
</script>
