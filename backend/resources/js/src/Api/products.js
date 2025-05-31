import httpClient from "./httpClient";

export async function getProducts() {
    const response = await httpClient.get('/products');
    return response.data;
}