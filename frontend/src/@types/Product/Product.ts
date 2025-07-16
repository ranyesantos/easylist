import { ProductColor } from "./ProductColor"

export interface Product {
    id?: number
    name: string
    description: string
    product_colors: ProductColor[]
}