import axios from "axios";

const httpClient = axios.create({
    baseURL: 'http://localhost:8001/api',
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

httpClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    config.headers.Authorization = token ? `Bearer ${token}` : undefined;
    return config;
});

export default httpClient;
