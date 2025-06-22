import { ProductInterface } from '@/types/Product';
import api from '../api';

interface ProductsResponse {
  products: ProductInterface[];
  status: string;
}

interface ProductResponse {
  product: ProductInterface;
  status: string;
}

export const getAllProducts = async (): Promise<ProductInterface[]> => {
  try {
    const response = await api.get<ProductsResponse>('/products');
    return response.data.products as ProductInterface[];
  } catch (error) {
    console.error('Error fetching products:', error);
    throw error;
  }
};

export const createProduct = async (product: ProductInterface) => {
  const response = await api.post<ProductResponse>('/products', product);
  return response.data.product as ProductInterface;
};