import { ProductInterface } from '@/types/Product';
import api from '../api';

interface ProductResponse {
  products: ProductInterface[];
  status: string;
}

export const getAllProducts = async (): Promise<ProductInterface[]> => {
  try {
    const response = await api.get<ProductResponse>('/products');
    return response.data.products as ProductInterface[];
  } catch (error) {
    console.error('Error fetching products:', error);
    throw error;
  }
};