import { Color } from '@/@types/Color/Color'
import api from '../axios'

export async function getColors(): Promise<Color[]>{
    const response = await api.get('/colors')
    
    return response.data
}
