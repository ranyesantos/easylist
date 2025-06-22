import api from '../api';

export interface ColorInterface {
    id: string,
    name: string
}

interface ColorResponse {
    colors: ColorInterface[],
    status: string
}

export const getAllColors = async (): Promise<ColorInterface[]> => {
    try {
        const response = await api.get<ColorResponse>('/colors');
        return response.data.colors as ColorInterface[];
    } catch (error){
        console.error(error);
        throw error;
    }
}

