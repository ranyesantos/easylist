import api from '../api';

export interface SizeInterface {
    id: number,
    size_description: string
}

interface SizeResponse {
    sizes: SizeInterface[],
    status: string
}

export const getAllSizes = async (): Promise<SizeInterface[]> => {
    try {
        const response = await api.get<SizeResponse>('/sizes');
        const fuck = response.data.sizes as SizeInterface[]
        console.log('fuck', fuck);
        return fuck;
    } catch (error) {
        console.error('erro:', error);
        throw error;
    }
}