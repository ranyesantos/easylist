import { Product } from "@/@types/Product/Product";
import { ProductForm } from "@/components/product/ProductForm";
import { createProduct } from "@/lib/services/ProductService";

export default function CreateProductPage() {

    return (
        <ProductForm/>
    )
}