import { Size } from "./Size"

export interface ProductColor {
    id?: number
    name: string
    color_id: number
    picture_url: string
    size_data: Size[]
}