// src/api/products.ts
import api from './api';

export interface Product {
  product_id: number;
  name: string;
  price: string;
}

interface ProductsResponse {
  products: Product[];
  status: string;
}

export const fetchProducts = async (): Promise<Product[]> => {
  try {
    const response = await api.get<ProductsResponse>('/products');
    return response.data.products as Product[];
  } catch (error) {
    console.error('Error fetching products:', error);
    throw error;
  }
};
