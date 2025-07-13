import { Product } from '@/@types/Product/Product'
import api from '../axios'

export async function getProducts(): Promise<Product>{
    const response = await api.get('/products')

    return response.data
}

export async function createProduct(data: Product): Promise<Product>{
    const response = await api.post<Product>('/products', data)

    return response.data
}