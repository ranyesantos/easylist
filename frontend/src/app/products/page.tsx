import { getProducts } from "@/lib/services/ProductService"

export default async function Page() {

    const products = await getProducts()
    
    return (
        <h1>oii</h1>
    )
}