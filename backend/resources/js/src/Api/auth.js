import httpClient from "./httpClient";

export async function login(email, password) {
    const response = await httpClient.post('/login', {
        email,
        password,
    });
    return response.data;
}