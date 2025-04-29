// src/api/api.ts
import axios from 'axios';

// Replace with your backend API URL
const apiUrl: string = process.env.VUE_APP_API_URL || 'http://localhost:8080';

const api = axios.create({
    baseURL: apiUrl,
    headers: {
        'Content-Type': 'application/json',
    },
});  

export default api;
