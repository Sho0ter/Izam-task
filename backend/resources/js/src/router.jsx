import { createBrowserRouter } from "react-router-dom";
import Login from "./views/login.jsx";
import Signup from "./views/signup.jsx";
import Products from "./views/products.jsx";
import Order from "./views/order.jsx";
import NotFound from "./views/404.jsx";
import App from "./App.jsx";

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        children: [
            {
                path: "login",
                element: <Login />,
            },
            {
                path: "signup",
                element: <Signup />,
            },
            {
                path: "products",
                element: <Products />,
            },
            {
                path: "order",
                element: <Order />,
            },
            {
                path: "*",
                element: <NotFound />,
            }
        ]
    },
])

export default router